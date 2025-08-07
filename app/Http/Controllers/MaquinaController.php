<?php

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

    /**
     * Listado de máquinas
     */
    public function index()
    {
        $this->authorize('ver maquinas');

        $maquinas = Maquina::with(['contrato', 'modelo', 'maquinaOriginal'])->get();

        return view('maquinas.index', compact('maquinas'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $this->authorize('crear maquinas');

        $contratos = Contrato::all();
        $modelos = ModeloMaquina::all();
        $maquinas = Maquina::with('modelo')->get(); // Para el campo de kit asociado

        return view('maquinas.create', compact('contratos', 'modelos', 'maquinas'));
    }

    /**
     * Guardar nueva máquina
     */
    public function store(Request $request)
    {
        $this->authorize('crear maquinas');

        $validated = $request->validate([
            'contrato_id'        => 'required|exists:contratos,id',
            'modelo_maquina_id'  => 'required|exists:modelos_maquina,id',
            'numero_maquina_ips' => 'required|string|max:50|unique:maquinas,numero_maquina_ips',
            'numero_serie'       => 'nullable|string|max:100',
            'maquina_origin_id'  => 'nullable|exists:maquinas,id',
            'fecha_alta'         => 'nullable|date',
            'fecha_baja'         => 'nullable|date|after_or_equal:fecha_alta',
        ]);

        Maquina::create($validated);

        return redirect()->route('maquinas.index')
            ->with('success', 'Máquina creada correctamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit(Maquina $maquina)
    {
        $this->authorize('editar maquinas');

        $contratos = Contrato::all();
        $modelos = ModeloMaquina::all();
        $maquinas = Maquina::where('id', '<>', $maquina->id)
            ->with('modelo')
            ->get(); // para no elegirse a sí misma

        return view('maquinas.edit', compact('maquina', 'contratos', 'modelos', 'maquinas'));
    }

    /**
     * Actualizar máquina
     */
    public function update(Request $request, Maquina $maquina)
    {
        $this->authorize('editar maquinas');

        $validated = $request->validate([
            'contrato_id'        => 'required|exists:contratos,id',
            'modelo_maquina_id'  => 'required|exists:modelos_maquina,id',
            'numero_maquina_ips' => 'required|string|max:50|unique:maquinas,numero_maquina_ips,' . $maquina->id,
            'numero_serie'       => 'nullable|string|max:100',
            'maquina_origin_id'  => 'nullable|exists:maquinas,id|different:' . $maquina->id,
            'fecha_alta'         => 'nullable|date',
            'fecha_baja'         => 'nullable|date|after_or_equal:fecha_alta',
        ]);

        $maquina->update($validated);

        return redirect()->route('maquinas.index')
            ->with('success', 'Máquina actualizada correctamente.');
    }

    /**
     * Eliminar máquina
     */
    public function destroy(Maquina $maquina)
    {
        $this->authorize('eliminar maquinas');

        $maquina->delete();

        return redirect()->route('maquinas.index')
            ->with('success', 'Máquina eliminada correctamente.');
    }
}
