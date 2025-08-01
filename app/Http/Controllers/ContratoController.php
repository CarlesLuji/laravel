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
use Illuminate\Support\Collection;
use Carbon\Carbon;

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
    $maquinasExistentes = Maquina::orderBy('numero_maquina_ips')->get(); // necesario para kit asociado

    return view('contratos.create', compact(
        'empresas',
        'proveedores',
        'modelos',
        'maquinasExistentes'
    ));
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
        'valor_residual' => 'nullable|numeric|min:0',
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
    'valor_residual' => $validated['valor_residual'] ?? 0,
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
        $modelos = ModeloMaquina::all();
        $maquinasExistentes = Maquina::all(); // Para el select de kits y máquinas existentes

        return view('contratos.edit', compact('contrato', 'empresas', 'proveedores','modelos','maquinasExistentes'));
    }

  public function update(Request $request, Contrato $contrato)
{
    $this->authorize('editar contratos');

    // Validación del contrato y de las máquinas
    $validated = $request->validate([
        'empresa_id' => 'required|exists:empresas,id',
        'proveedor_id' => 'required|exists:proveedores,id',
        'numero_contrato' => 'required|string|max:100|unique:contratos,numero_contrato,' . $contrato->id,
        'fecha_inicio' => 'required|date',
        'fecha_vencimiento' => 'required|date|after_or_equal:fecha_inicio',
        'duracion' => 'required|integer|min:1',
        'importe_mensual' => 'required|numeric|min:0',
        'iva' => 'required|numeric|min:0',
        'valor_residual' => 'nullable|numeric|min:0',

        // Máquinas
        'maquinas.*.id' => 'nullable|exists:maquinas,id',
        'maquinas.*.numero_maquina_ips' => 'required|string|max:100',
        'maquinas.*.numero_serie' => 'nullable|string|max:100',
        'maquinas.*.modelo_maquina_id' => 'required|exists:modelos_maquina,id',
        'maquinas.*.maquina_origin_id' => 'nullable|exists:maquinas,id',
        'maquinas.*.fecha_alta' => 'nullable|date',
        'maquinas.*.fecha_baja' => 'nullable|date|after_or_equal:maquinas.*.fecha_alta',
    ]);

    // Recalcular totales
    $totalMensual = round($validated['importe_mensual'] * (1 + $validated['iva'] / 100), 3);
    $totalContrato = round($totalMensual * $validated['duracion'], 3);

    // Actualizar contrato
    $contrato->update([
        'empresa_id' => $validated['empresa_id'],
        'proveedor_id' => $validated['proveedor_id'],
        'numero_contrato' => $validated['numero_contrato'],
        'fecha_inicio' => $validated['fecha_inicio'],
        'fecha_vencimiento' => $validated['fecha_vencimiento'],
        'duracion_meses' => $validated['duracion'],
        'importe_mensual' => $validated['importe_mensual'],
        'iva' => $validated['iva'],
        'valor_residual' => $validated['valor_residual'] ?? 0,
        'total_mensual' => $totalMensual,
        'total_contrato' => $totalContrato,
    ]);

    // ----------------- ACTUALIZAR MÁQUINAS ----------------- //

    $idsEnFormulario = [];

    if ($request->has('maquinas')) {
        foreach ($request->maquinas as $maquinaData) {
            if (!empty($maquinaData['id'])) {
                // Máquina existente -> Actualizar
                $maquina = $contrato->maquinas()->find($maquinaData['id']);
                if ($maquina) {
                    $maquina->update([
                        'numero_maquina_ips' => $maquinaData['numero_maquina_ips'],
                        'numero_serie' => $maquinaData['numero_serie'] ?? null,
                        'modelo_maquina_id' => $maquinaData['modelo_maquina_id'],
                        'maquina_origin_id' => $maquinaData['maquina_origin_id'] ?? null,
                        'fecha_alta' => $maquinaData['fecha_alta'] ?? null,
                        'fecha_baja' => $maquinaData['fecha_baja'] ?? null,
                    ]);
                    $idsEnFormulario[] = $maquina->id;
                }
            } else {
                // Nueva máquina
                $nueva = $contrato->maquinas()->create([
                    'numero_maquina_ips' => $maquinaData['numero_maquina_ips'],
                    'numero_serie' => $maquinaData['numero_serie'] ?? null,
                    'modelo_maquina_id' => $maquinaData['modelo_maquina_id'],
                    'maquina_origin_id' => $maquinaData['maquina_origin_id'] ?? null,
                    'fecha_alta' => $maquinaData['fecha_alta'] ?? null,
                    'fecha_baja' => $maquinaData['fecha_baja'] ?? null,
                ]);
                $idsEnFormulario[] = $nueva->id;
            }
        }
    }

    // Eliminar las máquinas que ya no están en el formulario
    $contrato->maquinas()->whereNotIn('id', $idsEnFormulario)->delete();

    return redirect()->route('contratos.index')->with('success', 'Contrato y máquinas actualizados correctamente.');
}






    public function destroy(Contrato $contrato)
    {
        $this->authorize('eliminar contratos');

        $contrato->delete();

        return redirect()->route('contratos.index')->with('success', 'Contrato eliminado correctamente.');
    }

    public function updateInline(Request $request)
{
    $this->authorize('editar contratos');

    $request->validate([
        'id' => 'required|exists:contratos,id',
        'column' => 'required|string|in:numero_contrato,fecha_inicio,fecha_vencimiento,duracion_meses,importe_mensual,iva,valor_residual',
        'value' => 'required'
    ]);

    $contrato = Contrato::findOrFail($request->id);

    $columna = $request->column;
    $valor = $request->value;

    // Si es campo numérico, castear y validar
    if (in_array($columna, ['importe_mensual', 'iva', 'valor_residual'])) {
        $valor = floatval(str_replace(',', '.', $valor));
    } elseif (in_array($columna, ['duracion_meses'])) {
        $valor = intval($valor);
    } elseif (in_array($columna, ['fecha_inicio', 'fecha_vencimiento'])) {
        try {
            $valor = \Carbon\Carbon::parse($valor)->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Fecha inválida'], 422);
        }
    }

    $contrato->$columna = $valor;
    $contrato->save();

    return response()->json(['success' => true, 'mensaje' => 'Contrato actualizado']);
}

public function cuotasMensuales()
{
    $contratos = Contrato::with(['empresa', 'proveedor'])->get();
    $cuotas = collect();

    foreach ($contratos as $contrato) {
        $inicio = $contrato->fecha_inicio->copy();
        $duracion = $contrato->duracion_meses;

        for ($i = 0; $i < $duracion; $i++) {
            $mes = $inicio->copy()->addMonths($i);
            $cuotas->push([
                'empresa' => $contrato->empresa->nombre ?? '',
                'proveedor' => $contrato->proveedor->nombre ?? '',
                'numero_contrato' => $contrato->numero_contrato,
                'mes' => $mes->format('Y-m'),
                'importe_mensual' => number_format($contrato->importe_mensual, 2, ',', '.'),
                'iva' => number_format($contrato->iva, 2, ',', '.'),
                'total_mensual' => number_format($contrato->total_mensual, 2, ',', '.'),
            ]);
        }
    }

    return view('contratos.cuotas_mensuales', ['cuotas' => $cuotas]);
}




}
