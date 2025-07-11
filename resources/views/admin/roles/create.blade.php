@extends('layouts.adminlte')

@section('content')<p></p>
<div class="container-fluid">
  <h1 class="h3 mb-4">Crear Rol</h1>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="permissions" class="form-label">Permisos</label>
          <select name="permissions[]" id="permissions" class="form-select" multiple>
            @foreach($permissions as $permission)
              <option value="{{ $permission->id }}">{{ $permission->name }}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check-lg"></i> Guardar
        </button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancelar</a>
      </form>
    </div>
  </div>
</div>
@endsection
