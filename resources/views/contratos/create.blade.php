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
          <div class="col-md-2">
            <label for="empresa_id" class="form-label">Empresa</label>
            <select name="empresa_id" id="empresa_id" class="form-select @error('empresa_id') is-invalid @enderror" required>
              <option value="">Selecciona una empresa</option>
              @foreach($empresas as $empresa)
                <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                  {{ $empresa->nombre }}
                </option>
              @endforeach
            </select>
            @error('empresa_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-2">
            <label for="proveedor_id" class="form-label">Proveedor</label>
            <select name="proveedor_id" id="proveedor_id" class="form-select @error('proveedor_id') is-invalid @enderror" required>
              <option value="">Selecciona un proveedor</option>
              @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                  {{ $proveedor->nombre }}
                </option>
              @endforeach
            </select>
            @error('proveedor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-2">
            <label for="numero_contrato" class="form-label">Nº Contrato (dejar en blanco)</label>
            <input type="text" name="numero_contrato" id="numero_contrato" value="{{ old('numero_contrato') }}" class="form-control @error('numero_contrato') is-invalid @enderror"readonly>
            @error('numero_contrato') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-2">
            <label for="fecha_firma" class="form-label">Fecha firma Contrato</label>
            <input type="date" name="fecha_firma" id="fecha_firma" value="{{ old('fecha_firma') }}"
             class="form-control @error('fecha_firma') is-invalid @enderror" required style="background-color: #d4edda;">
            @error('fecha_firma') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-2">
            <label for="fecha_inicio" class="form-label">Fecha Inicio primera Cuota</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" class="form-control @error('fecha_inicio') is-invalid @enderror" required>
            @error('fecha_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-2">
            <label for="fecha_vencimiento" class="form-label">Vencimiento última Cuota</label>
            <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}" class="form-control @error('fecha_vencimiento') is-invalid @enderror" required>
            @error('fecha_vencimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-2">
            <label for="duracion" class="form-label">Duración (meses)</label>
            <input type="number" name="duracion" id="duracion" value="{{ old('duracion') }}" class="form-control @error('duracion') is-invalid @enderror" min="1" required>
            @error('duracion') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-2">
            <label for="importe_mensual" class="form-label">Importe Mensual</label>
            <input type="number" step="0.01" name="importe_mensual" id="importe_mensual" value="{{ old('importe_mensual') }}" class="form-control @error('importe_mensual') is-invalid @enderror" required>
            @error('importe_mensual') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-2">
            <label for="iva" class="form-label">IVA (%)</label>
            <input type="number" step="0.01" name="iva" id="iva" value="{{ old('iva', 21) }}" class="form-control @error('iva') is-invalid @enderror">
            @error('iva') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-2">
            <label for="valor_residual" class="form-label">Valor Residual</label>
            <input type="number" step="0.01" name="valor_residual" id="valor_residual" value="{{ old('valor_residual') }}" class="form-control @error('valor_residual') is-invalid @enderror">
            @error('valor_residual') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
            @error('ruta_pdf') <div class="text-danger">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>

      <hr>
      <h5 class="h3 mb-4 px-3">Asociar Máquinas al Contrato</h5>

      <div id="maquinas-container" class="px-3">
        <div class="row maquina-item g-3 mb-2 border rounded p-3">
          <div class="col-md-3">
            <label class="form-label">Nº Máquina IPS (BB)</label>
            <input type="text" name="maquinas[0][numero_maquina_ips]" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Nº Serie</label>
            <input type="text" name="maquinas[0][numero_serie]" class="form-control">
          </div>
          <div class="col-md-3">
            <label class="form-label">Modelo</label>
            <select name="maquinas[0][modelo_maquina_id]" class="form-select">
              <option value="">-- Selecciona --</option>
              @foreach ($modelos as $modelo)
                <option value="{{ $modelo->id }}">{{ $modelo->marca }} - {{ $modelo->modelo }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-3">
          <label class="form-label">Permiso PDF (máquina)</label>
          <input 
            type="file" 
            name="maquinas[0][archivo_permiso]" 
            accept="application/pdf" 
            class="form-control form-control-sm" 
            style="background-color: #d4edda;">
        </div>
          <div class="col-md-3">
            <label class="form-label">Kit asociado (opcional)</label>
            <select name="maquinas[0][maquina_origin_id]" class="form-select">
              <option value="">—</option>
              @foreach ($maquinasExistentes as $m)
                <option value="{{ $m->id }}">{{ $m->numero_maquina_ips }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Fecha Alta</label>
            <input type="date" name="maquinas[0][fecha_alta]" class="form-control">
          </div>
          <div class="col-md-3">
            <label class="form-label">Fecha Baja</label>
            <input type="date" name="maquinas[0][fecha_baja]" class="form-control">
          </div>
          <div class="col-md-2 d-flex align-items-end gap-1">
  <button type="button" class="btn btn-outline-danger btn-sm w-50 add-maquina">
    <i class="bi bi-plus-lg">Añadir</i>
  </button>
  <button type="button" class="btn btn-outline-secondary btn-sm w-50 remove-last-maquina">
    <i class="bi bi-dash-lg">Eliminar</i>
  </button>
</div>

        </div>
      </div>

      <div class="card-footer text-end px-3">
        <a href="{{ route('contratos.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-danger">Guardar</button>
      </div>
    </div>
  </form>
</div>
@endsection
@push('styles')
<style>
  input[readonly] {
    background-color: #e0acc1ff !important; /* rosa pálido */
  }
</style>
@endpush
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('ruta_pdf');
    const span = document.getElementById('nombreArchivo');
    input.addEventListener('change', function () {
      span.textContent = input.files.length ? input.files[0].name : 'Ningún archivo seleccionado';
    });

    let index = 1;
    const container = document.getElementById('maquinas-container');

    container.addEventListener('click', function (e) {
      const addBtn = e.target.closest('.add-maquina');
      const removeBtn = e.target.closest('.remove-last-maquina');

      // Añadir nueva máquina
      if (addBtn) {
        const firstItem = container.querySelector('.maquina-item');
        const newItem = firstItem.cloneNode(true);

        newItem.querySelectorAll('input, select').forEach(el => {
          if (el.name) {
            el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
          }

          if (el.id) {
            el.id = el.id.replace(/_\d+$/, `_${index}`);
          }

          // Resetear valores excepto campos hidden
          if (el.type !== 'hidden') {
            el.value = '';
          }

          // Si es input file, limpiarlo (especialmente archivo_permiso)
          if (el.type === 'file') {
            el.value = '';
          }
        });

        container.appendChild(newItem);
        index++;
      }

      // Quitar última máquina añadida
      if (removeBtn) {
        const items = container.querySelectorAll('.maquina-item');
        if (items.length > 1) {
          items[items.length - 1].remove();
          index--;
        } else {
          alert('Debe haber al menos una máquina asociada.');
        }
      }
    });
  });
</script>
@endpush
