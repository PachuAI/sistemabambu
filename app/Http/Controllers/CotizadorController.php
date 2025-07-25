<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\NivelDescuento;

class CotizadorController extends Controller
{
    public function index()
    {
        $clientes = Cliente::take(5)->get();
        $productos = Producto::take(5)->get();
        $niveles = NivelDescuento::all();
        
        return view('cotizador.index', compact('clientes', 'productos', 'niveles'));
    }
}
