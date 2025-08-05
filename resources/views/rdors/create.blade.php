@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Crear Rdor</h1>
    </div>
    <div class="col text-end">
      <a href="{{ route('rdors.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('rdors.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
          <label for="codigo" class="form-label">Código</label>
          <input type="text" class="form-control" id="codigo" name="codigo" value="{{ old('codigo') }}" required>
        </div>

        <button type="submit" class="btn btn-danger">
          <i class="bi bi-save"></i> Guardar
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
