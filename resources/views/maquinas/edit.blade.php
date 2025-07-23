@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Editar Máquina</h1>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('maquinas.update', $maquina) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="numero_maquina_ips" class="form-label">Nº Máquina IPS</label>
            <input type="text" name="numero_maquina_ips" id="numero_maquina_ips"
              value="{{ old('numero_maquina_ips', $maquina->numero_maquina_ips) }}"
              class="form-control @error('numero_maquina_ips') is-invalid @enderror" required>
            @error('numero_maquina_ips')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="numero_serie" class="form-label">Nº Serie</label>
            <input type="text" name="numero_serie" id="numero_serie"
              value="{{ old('numero_serie', $maquina->numero_serie) }}"
              class="form-control @error('numero_serie') is-invalid @enderror" required>
            @error('numero_serie')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="modelo_maquina_id" class="form-label">Modelo</label>
            <select name="modelo_maquina_id" id="modelo_maquina_id"
              class="form-select @error('modelo_maquina_id') is-invalid @enderror" required>
              <option value="">-- Selecciona modelo --</option>
              @foreach ($modelos as $modelo)
                <option value="{{ $modelo->id }}"
                  {{ old('modelo_maquina_id', $maquina->modelo_maquina_id) == $modelo->id ? 'selected' : '' }}>
                  {{ $modelo->marca }} - {{ $modelo->modelo }}
                </option>
              @endforeach
            </select>
            @error('modelo_maquina_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="contrato_id" class="form-label">Contrato</label>
            <select name="contrato_id" id="contrato_id"
              class="form-select @error('contrato_id') is-invalid @enderror" required>
              <option value="">-- Selecciona contrato --</option>
              @foreach ($contratos as $contrato)
                <option value="{{ $contrato->id }}"
                  {{ old('contrato_id', $maquina->contrato_id) == $contrato->id ? 'selected' : '' }}>
                  {{ $contrato->numero_contrato }} ({{ $contrato->empresa->nombre }})
                </option>
              @endforeach
            </select>
            @error('contrato_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="text-end">
          <a href="{{ route('maquinas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
          <button type="submit" class="btn btn-outline-danger">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
