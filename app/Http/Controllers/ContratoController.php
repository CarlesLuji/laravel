<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Empresa;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContratoController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('ver contratos');

        $contratos = Contrato::with(['empresa', 'proveedor'])->get();
        return view('contratos.index', compact('contratos'));
    }

    public function create()
    {
        $this->authorize('crear contratos');

        $empresas = Empresa::all();
        $proveedores = Proveedor::all();

        return view('contratos.create', compact('empresas', 'proveedores'));
    }

    public function store(Request $request)
    {
        $this->authorize('crear contratos');

        $validated = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'n_contrato' => 'required|string|max:100|unique:contratos,n_contrato',
            'fecha_inicio' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_inicio',
            'duracion_meses' => 'required|integer|min:1',
            'importe_mensual' => 'required|numeric|min:0',
            'iva' => 'required|numeric|min:0',
            'total_mensual' => 'required|numeric|min:0',
            'total_contrato' => 'required|numeric|min:0',
        ]);

        Contrato::create($validated);

        return redirect()->route('contratos.index')->with('success', 'Contrato creado correctamente.');
    }

    public function edit(Contrato $contrato)
    {
        $this->authorize('editar contratos');

        $empresas = Empresa::all();
        $proveedores = Proveedor::all();

        return view('contratos.edit', compact('contrato', 'empresas', 'proveedores'));
    }

    public function update(Request $request, Contrato $contrato)
    {
        $this->authorize('editar contratos');

        $validated = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'n_contrato' => 'required|string|max:100|unique:contratos,n_contrato,' . $contrato->id,
            'fecha_inicio' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_inicio',
            'duracion_meses' => 'required|integer|min:1',
            'importe_mensual' => 'required|numeric|min:0',
            'iva' => 'required|numeric|min:0',
            'total_mensual' => 'required|numeric|min:0',
            'total_contrato' => 'required|numeric|min:0',
        ]);

        $contrato->update($validated);

        return redirect()->route('contratos.index')->with('success', 'Contrato actualizado correctamente.');
    }

    public function destroy(Contrato $contrato)
    {
        $this->authorize('eliminar contratos');

        $contrato->delete();

        return redirect()->route('contratos.index')->with('success', 'Contrato eliminado correctamente.');
    }
}
