@extends('layouts.adminlte')

@section('content')<p></p>
<div class="container-fluid">
  <h1 class="h3 mb-4">Crear Permiso</h1>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check-lg"></i> Guardar
        </button>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancelar</a>
      </form>
    </div>
  </div>
</div>
@endsection
