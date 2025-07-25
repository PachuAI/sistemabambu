<?php

namespace App\Livewire;

use App\Models\Reparto;
use App\Models\Vehiculo;
use Livewire\Component;
use Carbon\Carbon;

class SeguimientoEntregas extends Component
{
    public $fechaSeleccionada;
    public $vehiculoSeleccionado = null;
    
    public function mount()
    {
        $this->fechaSeleccionada = now()->format('Y-m-d');
    }

    public function cambiarEstado($repartoId, $nuevoEstado)
    {
        $reparto = Reparto::findOrFail($repartoId);
        $reparto->update(['estado' => $nuevoEstado]);
        
        // Actualizar estado del pedido según el estado del reparto
        if ($nuevoEstado === 'entregado') {
            $reparto->pedido->update(['estado' => 'entregado']);
        } elseif ($nuevoEstado === 'no_entregado') {
            $reparto->pedido->update(['estado' => 'no_entregado']);
        }

        $this->dispatch('reparto-actualizado', 
            mensaje: 'Estado actualizado correctamente'
        );
    }

    public function getRepartosProperty()
    {
        $query = Reparto::where('fecha_reparto', $this->fechaSeleccionada)
            ->with(['pedido.cliente.ciudad', 'vehiculo'])
            ->orderBy('orden_entrega');

        if ($this->vehiculoSeleccionado) {
            $query->where('vehiculo_id', $this->vehiculoSeleccionado);
        }

        return $query->get();
    }

    public function getVehiculosProperty()
    {
        return Vehiculo::activos()->get();
    }

    public function getEstadisticasProperty()
    {
        $repartos = $this->repartos;
        
        return [
            'total' => $repartos->count(),
            'planificados' => $repartos->where('estado', 'planificado')->count(),
            'en_ruta' => $repartos->where('estado', 'en_ruta')->count(),
            'entregados' => $repartos->where('estado', 'entregado')->count(),
            'no_entregados' => $repartos->where('estado', 'no_entregado')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.seguimiento-entregas-simple', [
            'repartos' => $this->repartos,
            'vehiculos' => $this->vehiculos
        ])->layout('layouts.app', ['title' => 'Seguimiento de Entregas']);
    }
}
