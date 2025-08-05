<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ConceptoController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('ver conceptos');

        $conceptos = Concepto::all();
        return view('conceptos.index', compact('conceptos'));
    }

    public function create()
    {
        $this->authorize('crear conceptos');

        return view('conceptos.create');
    }

    public function store(Request $request)
    {
        $this->authorize('crear conceptos');

        $validated = $request->validate([
            'concepto' => 'required|string|max:255',
            'cta' => 'required|string|max:20',
            'scta' => 'required|string|max:20',
            'type' => 'required|in:entrada,salida',
        ]);

        Concepto::create($validated);

        return redirect()->route('conceptos.index')->with('success', 'Concepto creado correctamente.');
    }

    public function edit(Concepto $concepto)
    {
        $this->authorize('editar conceptos');

        return view('conceptos.edit', compact('concepto'));
    }

    public function update(Request $request, Concepto $concepto)
    {
        $this->authorize('editar conceptos');

        $validated = $request->validate([
            'concepto' => 'required|string|max:255',
            'cta' => 'required|string|max:20',
            'scta' => 'required|string|max:20',
            'type' => 'required|in:entrada,salida',
        ]);

        $concepto->update($validated);

        return redirect()->route('conceptos.index')->with('success', 'Concepto actualizado correctamente.');
    }

    public function destroy(Concepto $concepto)
    {
        $this->authorize('eliminar conceptos');

        $concepto->delete();

        return redirect()->route('conceptos.index')->with('success', 'Concepto eliminado correctamente.');
    }
}
