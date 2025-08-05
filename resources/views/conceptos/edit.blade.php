@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Editar Concepto</h1>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('conceptos.update', $concepto) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="concepto" class="form-label">Concepto</label>
            <input type="text" name="concepto" id="concepto"
              value="{{ old('concepto', $concepto->concepto) }}"
              class="form-control @error('concepto') is-invalid @enderror" required>
            @error('concepto')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-3">
            <label for="cta" class="form-label">Cuenta</label>
            <input type="text" name="cta" id="cta"
              value="{{ old('cta', $concepto->cta) }}"
              class="form-control @error('cta') is-invalid @enderror" required>
            @error('cta')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-3">
            <label for="scta" class="form-label">Subcuenta</label>
            <input type="text" name="scta" id="scta"
              value="{{ old('scta', $concepto->scta) }}"
              class="form-control @error('scta') is-invalid @enderror" required>
            @error('scta')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="type" class="form-label">Tipo</label>
            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
              <option value="">-- Selecciona tipo --</option>
              <option value="entrada" {{ old('type', $concepto->type) == 'entrada' ? 'selected' : '' }}>Entrada</option>
              <option value="salida" {{ old('type', $concepto->type) == 'salida' ? 'selected' : '' }}>Salida</option>
            </select>
            @error('type')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="text-end">
          <a href="{{ route('conceptos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
          <button type="submit" class="btn btn-outline-danger">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
