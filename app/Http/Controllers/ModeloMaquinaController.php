<?php

namespace App\Http\Controllers;

use App\Models\ModeloMaquina;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ModeloMaquinaController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('ver modelos');

        $modelos = ModeloMaquina::all();
        return view('modelos_maquina.index', compact('modelos'));
    }

    public function create()
    {
        $this->authorize('crear modelos');

        return view('modelos_maquina.create');
    }

    public function store(Request $request)
    {
        $this->authorize('crear modelos');

        $validated = $request->validate([
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'codigo_modelo_ips' => 'nullable|string|max:50',
        ]);

        ModeloMaquina::create($validated);

        return redirect()->route('modelos-maquina.index')->with('success', 'Modelo creado correctamente.');
    }

    public function edit(ModeloMaquina $modeloMaquina)
    {
        $this->authorize('editar modelos');

        return view('modelos_maquina.edit', compact('modeloMaquina'));
    }

    public function update(Request $request, ModeloMaquina $modeloMaquina)
    {
        $this->authorize('editar modelos');

        $validated = $request->validate([
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'codigo_modelo_ips' => 'nullable|string|max:50',
        ]);

        $modeloMaquina->update($validated);

        return redirect()->route('modelos-maquina.index')->with('success', 'Modelo actualizado correctamente.');
    }

    public function destroy(ModeloMaquina $modeloMaquina)
    {
        $this->authorize('eliminar modelos');

        $modeloMaquina->delete();

        return redirect()->route('modelos-maquina.index')->with('success', 'Modelo eliminado correctamente.');
    }
}
