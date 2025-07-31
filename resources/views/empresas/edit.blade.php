@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Editar Empresa</h1>
    </div>
    <div class="col text-end">
      <a href="{{ route('empresas.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver al listado
      </a>
    </div>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow-sm">
    <div class="card-body">
      <form method="POST" action="{{ route('empresas.update', $empresa) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre de la empresa <span class="text-danger">*</span></label>
          <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $empresa->nombre) }}" required>
        </div>
        <div class="mb-3">
          <label for="alias" class="form-label">Alias <span class="text-danger">*</span></label>
          <input type="text" name="alias" id="alias" class="form-control" value="{{ old('alias', $empresa->alias) }}" required>
        </div>

        <div class="mb-3">
          <label for="direccion" class="form-label">Dirección</label>
          <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion', $empresa->direccion) }}">
        </div>

        <div class="mb-3">
          <label for="n_empresa_conta" class="form-label">Código empresa contable <span class="text-danger">*</span></label>
          <input type="text" name="n_empresa_conta" id="n_empresa_conta" class="form-control" value="{{ old('n_empresa_conta', $empresa->n_empresa_conta) }}" required>
        </div>

        <div class="mb-3">
          <label for="n_empresa_ips" class="form-label">Código empresa IPS</label>
          <input type="text" name="n_empresa_ips" id="n_empresa_ips" class="form-control" value="{{ old('n_empresa_ips', $empresa->n_empresa_ips) }}">
        </div>

        <div class="mb-3">
          <label for="cif" class="form-label">CIF <span class="text-danger">*</span></label>
          <input type="text" name="cif" id="cif" class="form-control" value="{{ old('cif', $empresa->cif) }}" required>
        </div>

        <div class="text-end">
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-save"></i> Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
