<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\Contrato;
use App\Models\ModeloMaquina;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MaquinaController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('ver maquinas');

        $maquinas = Maquina::with(['contrato', 'modelo'])->get();

        return view('maquinas.index', compact('maquinas'));
    }

    public function create()
    {
        $this->authorize('crear maquinas');

        $contratos = Contrato::all();
        $modelos = ModeloMaquina::all();

        return view('maquinas.create', compact('contratos', 'modelos'));
    }

    public function store(Request $request)
    {
        $this->authorize('crear maquinas');

        $validated = $request->validate([
            'contrato_id' => 'required|exists:contratos,id',
            'modelo_maquina_id' => 'required|exists:modelos_maquina,id',
            'numero_maquina_ips' => 'required|string|max:50|unique:maquinas,numero_maquina_ips',
            'numero_serie' => 'nullable|string|max:100',
        ]);

        Maquina::create($validated);

        return redirect()->route('maquinas.index')->with('success', 'Máquina creada correctamente.');
    }

    public function edit(Maquina $maquina)
    {
        $this->authorize('editar maquinas');

        $contratos = Contrato::all();
        $modelos = ModeloMaquina::all();

        return view('maquinas.edit', compact('maquina', 'contratos', 'modelos'));
    }

    public function update(Request $request, Maquina $maquina)
    {
        $this->authorize('editar maquinas');

        $validated = $request->validate([
            'contrato_id' => 'required|exists:contratos,id',
            'modelo_maquina_id' => 'required|exists:modelos_maquina,id',
            'numero_maquina_ips' => 'required|string|max:50|unique:maquinas,numero_maquina_ips,' . $maquina->id,
            'numero_serie' => 'nullable|string|max:100',
        ]);

        $maquina->update($validated);

        return redirect()->route('maquinas.index')->with('success', 'Máquina actualizada correctamente.');
    }

    public function destroy(Maquina $maquina)
    {
        $this->authorize('eliminar maquinas');

        $maquina->delete();

        return redirect()->route('maquinas.index')->with('success', 'Máquina eliminada correctamente.');
    }
}
