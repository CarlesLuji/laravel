@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Crear Máquina</h1>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('maquinas.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="numero_maquina_ips" class="form-label">Nº Máquina IPS</label>
            <input type="text" name="numero_maquina_ips" id="numero_maquina_ips" value="{{ old('numero_maquina_ips') }}"
              class="form-control @error('numero_maquina_ips') is-invalid @enderror" required>
            @error('numero_maquina_ips')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="numero_serie" class="form-label">Nº Serie</label>
            <input type="text" name="numero_serie" id="numero_serie" value="{{ old('numero_serie') }}"
              class="form-control @error('numero_serie') is-invalid @enderror">
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
                <option value="{{ $modelo->id }}" {{ old('modelo_maquina_id') == $modelo->id ? 'selected' : '' }}>
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
                <option value="{{ $contrato->id }}" {{ old('contrato_id') == $contrato->id ? 'selected' : '' }}>
                  {{ $contrato->numero_contrato }} ({{ $contrato->empresa->nombre }})
                </option>
              @endforeach
            </select>
            @error('contrato_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="maquina_origin_id" class="form-label">Kit de Máquina (opcional)</label>
            <select name="maquina_origin_id" id="maquina_origin_id"
              class="form-select @error('maquina_origin_id') is-invalid @enderror">
              <option value="">-- Sin kit asociado --</option>
              @foreach ($maquinas as $m)
                <option value="{{ $m->id }}" {{ old('maquina_origin_id') == $m->id ? 'selected' : '' }}>
                  {{ $m->numero_maquina_ips }} ({{ $m->modelo->modelo ?? 'Modelo desconocido' }})
                </option>
              @endforeach
            </select>
            @error('maquina_origin_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-2">
            <label for="fecha_alta" class="form-label">Fecha Alta</label>
            <input type="date" name="fecha_alta" id="fecha_alta"
              value="{{ old('fecha_alta') }}"
              class="form-control @error('fecha_alta') is-invalid @enderror">
            @error('fecha_alta')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-2">
            <label for="fecha_baja" class="form-label">Fecha Baja</label>
            <input type="date" name="fecha_baja" id="fecha_baja"
              value="{{ old('fecha_baja') }}"
              class="form-control @error('fecha_baja') is-invalid @enderror">
            @error('fecha_baja')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="text-end">
          <a href="{{ route('maquinas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
          <button type="submit" class="btn btn-outline-danger">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
