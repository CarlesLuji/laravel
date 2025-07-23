@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Editar Modelo de Máquina</h1>
    </div>
    <div class="col text-end">
      <a href="{{ route('modelos-maquina.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('modelos-maquina.update', $modeloMaquina) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" name="marca" id="marca" value="{{ old('marca', $modeloMaquina->marca) }}"
              class="form-control @error('marca') is-invalid @enderror" required>
            @error('marca')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="modelo" class="form-label">Modelo</label>
            <input type="text" name="modelo" id="modelo" value="{{ old('modelo', $modeloMaquina->modelo) }}"
              class="form-control @error('modelo') is-invalid @enderror" required>
            @error('modelo')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="codigo_modelo_ips" class="form-label">Código Modelo IPS</label>
            <input type="text" name="codigo_modelo_ips" id="codigo_modelo_ips" value="{{ old('codigo_modelo_ips', $modeloMaquina->codigo_modelo_ips) }}"
              class="form-control @error('codigo_modelo_ips') is-invalid @enderror">
            @error('codigo_modelo_ips')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="text-end">
          <button type="submit" class="btn btn-outline-danger">
            <i class="bi bi-save"></i> Actualizar Modelo
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
