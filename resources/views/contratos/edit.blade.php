@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <h1 class="h3 mb-4">Editar Contrato</h1>

  <form action="{{ route('contratos.update', $contrato) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card shadow">
      <div class="card-body">
        <div class="row g-3">

          <div class="col-md-6">
            <label for="empresa_id" class="form-label">Empresa</label>
            <select name="empresa_id" id="empresa_id" class="form-select @error('empresa_id') is-invalid @enderror" required>
              <option value="">Selecciona una empresa</option>
              @foreach($empresas as $empresa)
                <option value="{{ $empresa->id }}" {{ old('empresa_id', $contrato->empresa_id) == $empresa->id ? 'selected' : '' }}>
                  {{ $empresa->nombre }}
                </option>
              @endforeach
            </select>
            @error('empresa_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label for="proveedor_id" class="form-label">Proveedor</label>
            <select name="proveedor_id" id="proveedor_id" class="form-select @error('proveedor_id') is-invalid @enderror" required>
              <option value="">Selecciona un proveedor</option>
              @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}" {{ old('proveedor_id', $contrato->proveedor_id) == $proveedor->id ? 'selected' : '' }}>
                  {{ $proveedor->nombre }}
                </option>
              @endforeach
            </select>
            @error('proveedor_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="numero_contrato" class="form-label">Nº Contrato</label>
            <input type="text" name="numero_contrato" id="numero_contrato" value="{{ old('numero_contrato', $contrato->numero_contrato) }}" class="form-control @error('numero_contrato') is-invalid @enderror" required>
            @error('numero_contrato')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $contrato->fecha_inicio->format('Y-m-d')) }}" class="form-control @error('fecha_inicio') is-invalid @enderror" required>
            @error('fecha_inicio')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="fecha_vencimiento" class="form-label">Vencimiento</label>
            <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="{{ old('fecha_vencimiento', $contrato->fecha_vencimiento->format('Y-m-d')) }}" class="form-control @error('fecha_vencimiento') is-invalid @enderror" required>
            @error('fecha_vencimiento')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="duracion" class="form-label">Duración (meses)</label>
            <input type="number" name="duracion" id="duracion" value="{{ old('duracion', $contrato->duracion) }}" class="form-control @error('duracion') is-invalid @enderror" required>
            @error('duracion')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="importe_mensual" class="form-label">Importe Mensual</label>
            <input type="number" step="0.01" name="importe_mensual" id="importe_mensual" value="{{ old('importe_mensual', $contrato->importe_mensual) }}" class="form-control @error('importe_mensual') is-invalid @enderror" required>
            @error('importe_mensual')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="iva" class="form-label">IVA (%)</label>
            <input type="number" step="0.01" name="iva" id="iva" value="{{ old('iva', $contrato->iva) }}" class="form-control @error('iva') is-invalid @enderror">
            @error('iva')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

        </div>
      </div>

      <div class="card-footer text-end">
        <a href="{{ route('contratos.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-danger">Actualizar</button>
      </div>
    </div>
  </form>
</div>
@endsection
