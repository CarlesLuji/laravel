@extends('layouts.adminlte')

@section('content')<p></p>
<div class="container-fluid">
  <h1 class="h3 mb-4">Editar Permiso</h1>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" name="name" id="name" class="form-control" value="{{ $permission->name }}" required>
        </div>
        <button type="submit" class="btn btn-sm btn-outline-danger">
          <i class="bi bi-save"></i> Actualizar
        </button>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-sm btn-secondary">Cancelar</a>
      </form>
    </div>
  </div>
</div>
@endsection
