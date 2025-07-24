<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Empresa;
use App\Models\Proveedor;
use App\Models\ModeloMaquina;
use App\Models\Maquina;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
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
        $modelos = ModeloMaquina::all();
        return view('contratos.create', compact('empresas', 'proveedores', 'modelos'));

      
    }



public function store(Request $request)
{
    $this->authorize('crear contratos');

    $validated = $request->validate([
        'empresa_id' => 'required|exists:empresas,id',
        'proveedor_id' => 'required|exists:proveedores,id',
        'numero_contrato' => 'nullable|string|max:100|unique:contratos,numero_contrato',
        'fecha_inicio' => 'required|date',
        'fecha_vencimiento' => 'required|date|after_or_equal:fecha_inicio',
        'duracion' => 'required|integer|min:1',
        'importe_mensual' => 'required|numeric|min:0',
        'iva' => 'required|numeric|min:0',
        'ruta_pdf' => 'nullable|file|mimes:pdf|max:10240',
        'maquinas.*.numero_maquina_ips' => 'required|string|max:100',
        'maquinas.*.numero_serie' => 'nullable|string|max:100',
        'maquinas.*.modelo_maquina_id' => 'required|exists:modelos_maquina,id',
    ]);

    // Generar número de contrato si está vacío
    $numeroContrato = $validated['numero_contrato'] ?? 'CT-' . (Contrato::max('id') + 1);

    // Calcular totales
    $totalMensual = round($validated['importe_mensual'] * (1 + $validated['iva'] / 100), 3);
    $totalContrato = round($totalMensual * $validated['duracion'], 3);

    // Guardar archivo PDF si viene
    $nombreArchivo = null;
    if ($request->hasFile('ruta_pdf')) {
        $pdf = $request->file('ruta_pdf');
        $nombreArchivo = time() . '_' . $pdf->getClientOriginalName();
        $pdf->storeAs('contratos', $nombreArchivo, 'public');
    }

    // Crear contrato
    $contrato = Contrato::create([
        'empresa_id' => $validated['empresa_id'],
        'proveedor_id' => $validated['proveedor_id'],
        'numero_contrato' => $numeroContrato,
        'fecha_inicio' => $validated['fecha_inicio'],
        'fecha_vencimiento' => $validated['fecha_vencimiento'],
        'duracion_meses' => $validated['duracion'],
        'importe_mensual' => $validated['importe_mensual'],
        'iva' => $validated['iva'],
        'total_mensual' => $totalMensual,
        'total_contrato' => $totalContrato,
        'ruta_pdf' => $nombreArchivo,
    ]);

    // Crear máquinas asociadas
    foreach ($request->input('maquinas', []) as $maquinaData) {
        Maquina::create([
            'numero_maquina_ips' => $maquinaData['numero_maquina_ips'],
            'numero_serie' => $maquinaData['numero_serie'] ?? null,
            'modelo_maquina_id' => $maquinaData['modelo_maquina_id'],
            'contrato_id' => $contrato->id,
        ]);
    }

    return redirect()->route('contratos.index')->with('success', 'Contrato creado con éxito.');
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
