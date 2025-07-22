<?php
namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProveedorController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('ver proveedores');
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        $this->authorize('crear proveedores');
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $this->authorize('crear proveedores');

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cuenta_contable' => 'required|string|size:10|unique:proveedores,cuenta_contable',
        ]);

        Proveedor::create($validated);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente.');
    }

    public function edit(Proveedor $proveedor)
    {
        $this->authorize('editar proveedores');
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $this->authorize('editar proveedores');

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cuenta_contable' => 'required|string|size:10|unique:proveedores,cuenta_contable,' . $proveedor->id,
        ]);

        $proveedor->update($validated);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $this->authorize('eliminar proveedores');
        $proveedor->delete();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
