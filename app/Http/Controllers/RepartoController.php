<?php

namespace App\Http\Controllers;

use App\Models\Reparto;
use App\Models\Pedido;
use App\Models\Vehiculo;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RepartoController extends Controller
{
    /**
     * Muestra la vista de planificación de repartos
     */
    public function index(Request $request)
    {
        $fechaSeleccionada = $request->get('fecha', now()->format('Y-m-d'));
        
        // Obtener vehículos activos
        $vehiculos = Vehiculo::activos()->get();
        
        // Obtener pedidos confirmados disponibles para reparto
        $pedidosDisponibles = Pedido::where('estado', 'confirmado')
            ->whereDoesntHave('repartos', function($query) use ($fechaSeleccionada) {
                $query->where('fecha_reparto', $fechaSeleccionada);
            })
            ->with(['cliente.ciudad', 'items.producto'])
            ->get();
        
        // Obtener repartos ya planificados para la fecha
        $repartosDelDia = Reparto::porFecha($fechaSeleccionada)
            ->with(['pedido.cliente.ciudad', 'vehiculo'])
            ->ordenadoPorEntrega()
            ->get()
            ->groupBy('vehiculo_id');
        
        // Generar resumen por ciudad
        $resumenCiudades = $this->generarResumenPorCiudad($fechaSeleccionada);
        
        return view('repartos.index', compact(
            'fechaSeleccionada',
            'vehiculos', 
            'pedidosDisponibles',
            'repartosDelDia',
            'resumenCiudades'
        ));
    }

    /**
     * Asigna un pedido a un vehículo para una fecha específica
     */
    public function asignar(Request $request)
    {
        $request->validate([
            'fecha_reparto' => 'required|date',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'pedido_id' => 'required|exists:pedidos,id',
            'orden_entrega' => 'required|integer|min:1'
        ]);

        $pedido = Pedido::findOrFail($request->pedido_id);
        $vehiculo = Vehiculo::findOrFail($request->vehiculo_id);
        
        // Verificar que el vehículo tenga capacidad
        $bultosDisponibles = $vehiculo->bultosDisponibles($request->fecha_reparto);
        if ($bultosDisponibles < $pedido->bultos_totales) {
            return back()->with('error', 
                "El vehículo no tiene capacidad suficiente. Disponible: {$bultosDisponibles} bultos, Necesario: {$pedido->bultos_totales} bultos"
            );
        }

        DB::transaction(function() use ($request, $pedido) {
            // Crear el reparto
            Reparto::create([
                'fecha_reparto' => $request->fecha_reparto,
                'vehiculo_id' => $request->vehiculo_id,
                'pedido_id' => $request->pedido_id,
                'bultos_asignados' => $pedido->bultos_totales,
                'orden_entrega' => $request->orden_entrega,
                'estado' => 'planificado'
            ]);

            // Actualizar estado del pedido
            $pedido->update(['estado' => 'en_reparto']);
        });

        return back()->with('success', 'Pedido asignado al reparto correctamente');
    }

    /**
     * Remueve un pedido del reparto
     */
    public function desasignar(Reparto $reparto)
    {
        DB::transaction(function() use ($reparto) {
            // Volver el pedido a estado confirmado
            $reparto->pedido->update(['estado' => 'confirmado']);
            
            // Eliminar el reparto
            $reparto->delete();
        });

        return back()->with('success', 'Pedido removido del reparto');
    }

    /**
     * Genera resumen por ciudad para la fecha seleccionada
     */
    private function generarResumenPorCiudad($fecha)
    {
        return Reparto::porFecha($fecha)
            ->join('pedidos', 'repartos.pedido_id', '=', 'pedidos.id')
            ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
            ->join('ciudades', 'clientes.ciudad_id', '=', 'ciudades.id')
            ->select(
                'ciudades.nombre as ciudad',
                DB::raw('SUM(repartos.bultos_asignados) as total_bultos'),
                DB::raw('COUNT(DISTINCT pedidos.cliente_id) as total_clientes'),
                DB::raw('COUNT(repartos.id) as total_pedidos')
            )
            ->groupBy('ciudades.id', 'ciudades.nombre')
            ->orderBy('ciudades.nombre')
            ->get();
    }
}