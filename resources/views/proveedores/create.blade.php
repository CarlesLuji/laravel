@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Crear Proveedor</h1>
    </div>
    <div class="col text-end">
      <a href="{{ route('proveedores.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('proveedores.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="mb-3">
          <label for="cuenta_contable" class="form-label">Cuenta contable</label>
          <input type="text" class="form-control" id="cuenta_contable" name="cuenta_contable" required>
        </div>

        <button type="submit" class="btn btn-danger">
          <i class="bi bi-save"></i> Guardar
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
