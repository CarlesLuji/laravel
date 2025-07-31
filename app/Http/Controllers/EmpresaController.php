<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmpresaController extends Controller
{  use AuthorizesRequests; // ✅ CORRECTO: dentro de la clase, pero fuera de los métodos 
    public function index()
    {
        
        $this->authorize('ver empresas');

        $empresas = Empresa::all();
        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        $this->authorize('crear empresas');

        return view('empresas.create');
    }

    public function store(Request $request)
    {
        $this->authorize('crear empresas');

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'alias' => 'required|string|max:25',
            'direccion' => 'nullable|string|max:255',
            'n_empresa_conta' => 'required|string|max:25',
            'n_empresa_ips' => 'nullable|string|max:20',
            'cif' => 'required|string|size:9|unique:empresas,cif',
        ]);

        Empresa::create($validated);

        return redirect()->route('empresas.index')->with('success', 'Empresa creada correctamente.');
    }

    public function edit(Empresa $empresa)
    {
        $this->authorize('editar empresas');

        return view('empresas.edit', compact('empresa'));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $this->authorize('editar empresas');

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'alias' => 'required|string|max:25',
            'direccion' => 'nullable|string|max:255',
            'n_empresa_conta' => 'required|string|max:20',
            'n_empresa_ips' => 'nullable|string|max:20',
            'cif' => 'required|string|size:9|unique:empresas,cif,' . $empresa->id,
        ]);

        $empresa->update($validated);

        return redirect()->route('empresas.index')->with('success', 'Empresa actualizada correctamente.');
    }

    public function destroy(Empresa $empresa)
    {
        $this->authorize('eliminar empresas');

        $empresa->delete();

        return redirect()->route('empresas.index')->with('success', 'Empresa eliminada correctamente.');
    }
}
