@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <h1 class="h3 mb-4">Crear Contrato</h1>

  <form action="{{ route('contratos.store') }}" method="POST" enctype="multipart/form-data">

    @csrf
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
          <div class="col-md-3">
            <label for="empresa_id" class="form-label">Empresa</label>
            <select name="empresa_id" id="empresa_id" class="form-select @error('empresa_id') is-invalid @enderror" required>
              <option value="">Selecciona una empresa</option>
              @foreach($empresas as $empresa)
                <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                  {{ $empresa->nombre }}
                </option>
              @endforeach
            </select>
            @error('empresa_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-3">
            <label for="proveedor_id" class="form-label">Proveedor</label>
            <select name="proveedor_id" id="proveedor_id" class="form-select @error('proveedor_id') is-invalid @enderror" required>
              <option value="">Selecciona un proveedor</option>
              @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                  {{ $proveedor->nombre }}
                </option>
              @endforeach
            </select>
            @error('proveedor_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-2">
            <label for="numero_contrato" class="form-label">Nº Contrato</label>
            <input type="text" name="numero_contrato" id="numero_contrato" value="{{ old('numero_contrato') }}" class="form-control @error('numero_contrato') is-invalid @enderror">
            @error('numero_contrato')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-2">
            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" class="form-control @error('fecha_inicio') is-invalid @enderror" required>
            @error('fecha_inicio')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-2">
            <label for="fecha_vencimiento" class="form-label">Vencimiento</label>
            <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}" class="form-control @error('fecha_vencimiento') is-invalid @enderror" required>
            @error('fecha_vencimiento')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-2">
            <label for="duracion" class="form-label">Duración (meses)</label>
            <input type="number" name="duracion" id="duracion" value="{{ old('duracion') }}" class="form-control @error('duracion') is-invalid @enderror" min="1" required>
            @error('duracion')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-2">
            <label for="importe_mensual" class="form-label">Importe Mensual</label>
            <input type="number" step="0.01" name="importe_mensual" id="importe_mensual" value="{{ old('importe_mensual') }}" class="form-control @error('importe_mensual') is-invalid @enderror" required>
            @error('importe_mensual')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-2">
            <label for="iva" class="form-label">IVA (%)</label>
            <input type="number" step="0.01" name="iva" id="iva" value="{{ old('iva', 21) }}" class="form-control @error('iva') is-invalid @enderror">
            @error('iva')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-2">
  <label for="valor_residual" class="form-label">Valor Residual</label>
  <input type="number" step="0.01" name="valor_residual" id="valor_residual" value="{{ old('valor_residual') }}" class="form-control @error('valor_residual') is-invalid @enderror">
  @error('valor_residual')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

 <div class="col-md-3">
    <label for="ruta_pdf" class="form-label">Contrato PDF</label>

    <div class="input-group align-items-center">
        <label class="btn btn-danger mb-0" for="ruta_pdf">
            <i class="bi bi-upload"></i>
        </label>
        <input type="file" name="ruta_pdf" id="ruta_pdf" class="d-none" accept="application/pdf">
        <span id="nombreArchivo" class="ms-2 text-muted small">Ningún archivo seleccionado</span>
    </div>

    @error('ruta_pdf')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    @isset($contrato)
        @if ($contrato->ruta_pdf)
            <p class="mt-2">
                <a href="{{ asset('storage/contratos/' . $contrato->ruta_pdf) }}" target="_blank">
                    Ver contrato actual
                </a>
            </p>
        @endif
    @endisset
</div>


        </div>
      </div>
<hr>
<h5 class="h3 mb-4">&nbsp;&nbsp;Asociar Máquinas al Contrato de Renting</h5>

<div id="maquinas-container">
  <div class="row maquina-item g-3 mb-2 border rounded p-3">
    <div class="col-md-3">
      <label for="numero_maquina_ips_0" class="form-label">Nº Máquina IPS</label>
      <input type="text" name="maquinas[0][numero_maquina_ips]" id="numero_maquina_ips_0" class="form-control" required>
    </div>
    <div class="col-md-3">
      <label for="numero_serie_0" class="form-label">Nº Serie</label>
      <input type="text" name="maquinas[0][numero_serie]" id="numero_serie_0" class="form-control">
    </div>
    <div class="col-md-4">
      <label for="modelo_maquina_id_0" class="form-label">Modelo</label>
      <select name="maquinas[0][modelo_maquina_id]" id="modelo_maquina_id_0" class="form-select">
        <option value="">-- Selecciona --</option>
        @foreach ($modelos as $modelo)
          <option value="{{ $modelo->id }}">{{ $modelo->marca }} - {{ $modelo->modelo }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button type="button" class="btn btn-outline-danger btn-sm w-100 add-maquina">
        <i class="bi bi-plus-lg"></i> Añadir
      </button>
    </div>
  </div>
</div>

      <div class="card-footer text-end">
        <a href="{{ route('contratos.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-danger">Guardar</button>
      </div>
    </div>
  </form>
</div>
@endsection
@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('ruta_pdf');
        const span = document.getElementById('nombreArchivo');

        input.addEventListener('change', function () {
            if (input.files.length > 0) {
                span.textContent = input.files[0].name;
            } else {
                span.textContent = 'Ningún archivo seleccionado';
            }
        });
    });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    let index = 1;

    document.querySelector('#maquinas-container').addEventListener('click', function (e) {
      if (e.target.closest('.add-maquina')) {
        const container = document.getElementById('maquinas-container');
        const firstItem = container.querySelector('.maquina-item');
        const newItem = firstItem.cloneNode(true);

        newItem.querySelectorAll('input, select').forEach(el => {
          if (el.name) {
            el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
            el.id = el.id.replace(/_\d+$/, `_${index}`);
            el.value = '';
          }
        });

        container.appendChild(newItem);
        index++;
      }
    });
  });
</script>

@endpush
