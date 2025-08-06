@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <h1 class="h3 mb-4">Editar Contrato</h1>

  <form action="{{ route('contratos.update', $contrato) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card shadow">
      <div class="card-body">
        <div class="row g-3">
          {{-- Empresa --}}
          <div class="col-md-3">
            <label for="empresa_id" class="form-label">Empresa</label>
            <select name="empresa_id" id="empresa_id" class="form-select @error('empresa_id') is-invalid @enderror" required>
              <option value="">Selecciona una empresa</option>
              @foreach($empresas as $empresa)
                <option value="{{ $empresa->id }}" {{ old('empresa_id', $contrato->empresa_id) == $empresa->id ? 'selected' : '' }}>
                  {{ $empresa->nombre }}
                </option>
              @endforeach
            </select>
            @error('empresa_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Proveedor --}}
          <div class="col-md-3">
            <label for="proveedor_id" class="form-label">Proveedor</label>
            <select name="proveedor_id" id="proveedor_id" class="form-select @error('proveedor_id') is-invalid @enderror" required>
              <option value="">Selecciona un proveedor</option>
              @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}" {{ old('proveedor_id', $contrato->proveedor_id) == $proveedor->id ? 'selected' : '' }}>
                  {{ $proveedor->nombre }}
                </option>
              @endforeach
            </select>
            @error('proveedor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Nº Contrato --}}
          <div class="col-md-2">
            <label for="numero_contrato" class="form-label">Nº Contrato</label>
            <input type="text" name="numero_contrato" id="numero_contrato" 
                   value="{{ old('numero_contrato', $contrato->numero_contrato) }}" 
                   class="form-control @error('numero_contrato') is-invalid @enderror">
            @error('numero_contrato') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Fechas --}}
          <div class="col-md-2">
    <label for="fecha_firma" class="form-label">Fecha Firma</label>
    <input type="date" name="fecha_firma" id="fecha_firma"
           value="{{ old('fecha_firma', $contrato->fecha_firma ? $contrato->fecha_firma->format('Y-m-d') : '') }}" 
           class="form-control @error('fecha_firma') is-invalid @enderror" required>
    @error('fecha_firma') 
        <div class="invalid-feedback">{{ $message }}</div> 
    @enderror
</div>
          <div class="col-md-2">
            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio"
                   value="{{ old('fecha_inicio', $contrato->fecha_inicio->format('Y-m-d')) }}" 
                   class="form-control @error('fecha_inicio') is-invalid @enderror" required>
            @error('fecha_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-2">
            <label for="fecha_vencimiento" class="form-label">Vencimiento</label>
            <input type="date" name="fecha_vencimiento" id="fecha_vencimiento"
                   value="{{ old('fecha_vencimiento', $contrato->fecha_vencimiento->format('Y-m-d')) }}" 
                   class="form-control @error('fecha_vencimiento') is-invalid @enderror" required>
            @error('fecha_vencimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Duración --}}
          <div class="col-md-2">
            <label for="duracion" class="form-label">Duración (meses)</label>
            <input type="number" name="duracion" id="duracion"
                   value="{{ old('duracion', $contrato->duracion_meses) }}" 
                   class="form-control @error('duracion') is-invalid @enderror" min="1" required>
            @error('duracion') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Importe --}}
          <div class="col-md-2">
            <label for="importe_mensual" class="form-label">Importe Mensual</label>
            <input type="number" step="0.01" name="importe_mensual" id="importe_mensual"
                   value="{{ old('importe_mensual', $contrato->importe_mensual) }}" 
                   class="form-control @error('importe_mensual') is-invalid @enderror" required>
            @error('importe_mensual') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- IVA --}}
          <div class="col-md-2">
            <label for="iva" class="form-label">IVA (%)</label>
            <input type="number" step="0.01" name="iva" id="iva"
                   value="{{ old('iva', $contrato->iva) }}" 
                   class="form-control @error('iva') is-invalid @enderror">
            @error('iva') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Valor residual --}}
          <div class="col-md-2">
            <label for="valor_residual" class="form-label">Valor Residual</label>
            <input type="number" step="0.01" name="valor_residual" id="valor_residual"
                   value="{{ old('valor_residual', $contrato->valor_residual) }}" 
                   class="form-control @error('valor_residual') is-invalid @enderror">
            @error('valor_residual') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- PDF contrato --}}
          <div class="col-md-4">
            <label for="ruta_pdf" class="form-label">Contrato PDF</label>
            <div class="input-group align-items-center">
              <label class="btn btn-danger mb-0" for="ruta_pdf">
                <i class="bi bi-upload"></i>
              </label>
              <input type="file" name="ruta_pdf" id="ruta_pdf" class="d-none" accept="application/pdf">
              <span id="nombreArchivo" class="ms-2 text-muted small">
                {{ $contrato->ruta_pdf ? $contrato->ruta_pdf : 'Ningún archivo seleccionado' }}
              </span>
            </div>
            @error('ruta_pdf') <div class="text-danger mt-1">{{ $message }}</div> @enderror

            @if ($contrato->ruta_pdf)
              <p class="mt-2">
                <a href="{{ asset('storage/contratos/' . $contrato->ruta_pdf) }}" target="_blank" class="btn btn-sm btn-outline-success">
                  <i class="bi bi-file-earmark-pdf"></i> Ver PDF actual
                </a>
              </p>
            @endif
          </div>

        </div>
      </div>

      {{-- Máquinas asociadas --}}
      <h5 class="h3 mb-4 px-3">Máquinas asociadas al Contrato</h5>
      <div id="maquinas-container" class="px-3">
        @foreach($contrato->maquinas as $i => $maquina)
          <div class="row maquina-item g-2 mb-2 border rounded p-3 align-items-end">
            <input type="hidden" name="maquinas[{{ $i }}][id]" value="{{ $maquina->id }}">
            <div class="col-md-2">
              <label class="form-label">Nº Máquina IPS (BB)</label>
              <input type="text" name="maquinas[{{ $i }}][numero_maquina_ips]" value="{{ $maquina->numero_maquina_ips }}" class="form-control" required>
            </div>
            <div class="col-md-2">
              <label class="form-label">Nº Serie</label>
              <input type="text" name="maquinas[{{ $i }}][numero_serie]" value="{{ $maquina->numero_serie }}" class="form-control">
            </div>
            <div class="col-md-2">
              <label class="form-label">Modelo</label>
              <select name="maquinas[{{ $i }}][modelo_maquina_id]" class="form-select">
                @foreach($modelos as $modelo)
                  <option value="{{ $modelo->id }}" {{ $maquina->modelo_maquina_id == $modelo->id ? 'selected' : '' }}>
                    {{ $modelo->marca }} - {{ $modelo->modelo }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label">Kit asociado</label>
              <select name="maquinas[{{ $i }}][maquina_origin_id]" class="form-select">
                <option value="">— Ninguno —</option>
                @foreach($maquinasExistentes as $m)
                  <option value="{{ $m->id }}" {{ $maquina->maquina_origin_id == $m->id ? 'selected' : '' }}>
                    {{ $m->numero_maquina_ips }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-1">
              <label class="form-label">Alta</label>
              <input type="date" name="maquinas[{{ $i }}][fecha_alta]" value="{{ $maquina->fecha_alta }}" class="form-control">
            </div>
            <div class="col-md-1">
              <label class="form-label">Baja</label>
              <input type="date" name="maquinas[{{ $i }}][fecha_baja]" value="{{ $maquina->fecha_baja }}" class="form-control">
            </div>
            <div class="col-md-3">
  <label class="form-label">Permiso PDF (máquina)</label>
  @if($maquina->archivo_permiso)
    <p class="mb-1">
      <a href="{{ asset('storage/maquinas/' . $maquina->archivo_permiso) }}" target="_blank" class="btn btn-sm btn-outline-success">
        <i class="bi bi-file-earmark-pdf-fill"></i> Ver PDF
      </a>
    </p>
  @endif
  <input type="file" 
         name="maquinas[{{ $i }}][archivo_permiso]" 
         accept="application/pdf" 
         class="form-control form-control-sm" 
         style="background-color: #d4edda;">
</div>
            <div class="col-md-1 text-center">
              <button type="button" class="btn btn-sm btn-outline-danger remove-maquina mt-4">
                <i class="bi bi-trash">Eliminar</i>
              </button>
            </div>
          </div>
        @endforeach
      </div>
      <div class="px-3 mb-3">
        <button type="button" id="add-maquina" class="btn btn-sm btn-outline-danger">
          <i class="bi bi-plus-lg"></i> Añadir máquina
        </button>
      </div>

      <div class="card-footer text-end">
        <a href="{{ route('contratos.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-danger">Actualizar</button>
      </div>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    let index = {{ count($contrato->maquinas) }};

    document.getElementById('add-maquina').addEventListener('click', function () {
      const container = document.getElementById('maquinas-container');
      const template = container.querySelector('.maquina-item');
      const clone = template.cloneNode(true);

      clone.querySelectorAll('input, select').forEach(el => {
        if (el.type !== 'hidden') el.value = '';
        if (el.name) el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
        if (el.id) el.id = el.id.replace(/_\d+$/, `_${index}`);
      });

      container.appendChild(clone);
      index++;
    });

    document.getElementById('maquinas-container').addEventListener('click', function (e) {
      if (e.target.closest('.remove-maquina')) {
        const item = e.target.closest('.maquina-item');
        if (document.querySelectorAll('.maquina-item').length > 1) {
          item.remove();
        } else {
          alert('Debe haber al menos una máquina asociada.');
        }
      }
    });

    const inputPdf = document.getElementById('ruta_pdf');
    const nombreArchivo = document.getElementById('nombreArchivo');
    inputPdf.addEventListener('change', function () {
      if (this.files.length > 0) {
        nombreArchivo.textContent = this.files[0].name;
      } else {
        nombreArchivo.textContent = 'Ningún archivo seleccionado';
      }
    });
  });
</script>
@endpush

