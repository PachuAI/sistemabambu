<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('ciudad')
            ->orderBy('nombre')
            ->paginate(15);
            
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        $ciudades = Ciudad::orderBy('nombre')->get();
        return view('clientes.create', compact('ciudades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string|max:255|unique:clientes',
            'telefono' => 'required|string|max:20',
            'ciudad_id' => 'required|exists:ciudades,id',
            'email' => 'nullable|email|max:100',
        ]);

        $cliente = Cliente::create($validated);
        
        return redirect()
            ->route('clientes.show', $cliente)
            ->with('success', 'Cliente creado exitosamente.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load('ciudad');
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        $ciudades = Ciudad::orderBy('nombre')->get();
        return view('clientes.edit', compact('cliente', 'ciudades'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => [
                'required',
                'string',
                'max:255',
                Rule::unique('clientes')->ignore($cliente->id)
            ],
            'telefono' => 'required|string|max:20',
            'ciudad_id' => 'required|exists:ciudades,id',
            'email' => 'nullable|email|max:100',
        ]);

        $cliente->update($validated);
        
        return redirect()
            ->route('clientes.show', $cliente)
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        
        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}
