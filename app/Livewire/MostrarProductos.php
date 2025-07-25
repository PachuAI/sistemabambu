<?php
namespace App\Livewire;
use App\Models\Producto; // <-- Añade esta línea al principio del archivo



use Livewire\Component;

class MostrarProductos extends Component
{
    public function render()
    {
        return view('livewire.mostrar-productos', [
        'productos' => Producto::all()
    ]);
    }
}
