<?php

namespace App\Http\Controllers;

use App\Models\Reparto;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    public function index(Request $request)
    {
        $fechaSeleccionada = $request->get('fecha', now()->format('Y-m-d'));
        $vehiculoSeleccionado = $request->get('vehiculo_id');
        
        // Obtener vehículos activos
        $vehiculos = Vehiculo::where('activo', true)->get();
        
        // Obtener repartos del día
        $query = Reparto::where('fecha_reparto', $fechaSeleccionada)
            ->with(['pedido.cliente.ciudad', 'vehiculo'])
            ->orderBy('orden_entrega');

        if ($vehiculoSeleccionado) {
            $query->where('vehiculo_id', $vehiculoSeleccionado);
        }

        $repartos = $query->get();
        
        // Calcular estadísticas
        $estadisticas = [
            'total' => $repartos->count(),
            'planificados' => $repartos->where('estado', 'planificado')->count(),
            'en_ruta' => $repartos->where('estado', 'en_ruta')->count(),
            'entregados' => $repartos->where('estado', 'entregado')->count(),
            'no_entregados' => $repartos->where('estado', 'no_entregado')->count(),
        ];
        
        return view('seguimiento.index', compact(
            'fechaSeleccionada',
            'vehiculoSeleccionado', 
            'vehiculos',
            'repartos',
            'estadisticas'
        ));
    }
    
    public function cambiarEstado(Request $request, Reparto $reparto)
    {
        $request->validate([
            'estado' => 'required|in:planificado,en_ruta,entregado,no_entregado'
        ]);
        
        $reparto->update(['estado' => $request->estado]);
        
        // Actualizar estado del pedido según el estado del reparto
        if ($request->estado === 'entregado') {
            $reparto->pedido->update(['estado' => 'entregado']);
        } elseif ($request->estado === 'no_entregado') {
            $reparto->pedido->update(['estado' => 'no_entregado']);
        }
        
        return back()->with('success', 'Estado actualizado correctamente');
    }
}
