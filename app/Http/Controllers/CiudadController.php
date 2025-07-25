<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Provincia;
use Illuminate\Http\Request;

class CiudadController extends Controller
{
    public function index()
    {
        $ciudades = Ciudad::with('provincia')->paginate(10);
        return view('ciudades.index', compact('ciudades'));
    }

    public function create()
    {
        $provincias = Provincia::orderBy('nombre')->get();
        return view('ciudades.create', compact('provincias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:ciudades',
            'provincia_id' => 'required|exists:provincias,id',
            'codigo_postal' => 'nullable|string|max:10',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
        ]);

        Ciudad::create($request->all());
        return redirect()->route('ciudades.index')->with('success', 'Ciudad creada exitosamente');
    }

    public function show(Ciudad $ciudad)
    {
        return view('ciudades.show', compact('ciudad'));
    }

    public function edit(Ciudad $ciudad)
    {
        $provincias = Provincia::orderBy('nombre')->get();
        return view('ciudades.edit', compact('ciudad', 'provincias'));
    }

    public function update(Request $request, Ciudad $ciudad)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:ciudades,nombre,' . $ciudad->id,
            'provincia_id' => 'required|exists:provincias,id',
            'codigo_postal' => 'nullable|string|max:10',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
        ]);

        $ciudad->update($request->all());
        return redirect()->route('ciudades.index')->with('success', 'Ciudad actualizada exitosamente');
    }

    public function destroy(Ciudad $ciudad)
    {
        $ciudad->delete();
        return redirect()->route('ciudades.index')->with('success', 'Ciudad eliminada exitosamente');
    }
}
