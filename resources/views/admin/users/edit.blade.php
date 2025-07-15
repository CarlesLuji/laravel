@extends('layouts.adminlte')

@section('content')<p></p>
<div class="container-fluid">
  <h1 class="h3 mb-4">Editar Usuario</h1>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
          <label for="roles" class="form-label">Roles</label>
          <select name="roles[]" id="roles" class="form-select" multiple>
  @foreach($roles as $role)
    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
      {{ $role->name }}
    </option>
  @endforeach
</select>
        </div>
        <button type="submit" class="btn btn-sm btn-outline-danger">
          <i class="bi bi-save"></i> Actualizar
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">Cancelar</a>
      </form>
    </div>
  </div>
</div>
@endsection
