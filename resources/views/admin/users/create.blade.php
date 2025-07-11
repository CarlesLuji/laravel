@extends('layouts.adminlte')

@section('content')<p></p>
<div class="container-fluid">
  <h1 class="h3 mb-4">Crear Usuario</h1>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="roles" class="form-label">Roles</label>
          <select name="roles[]" id="roles" class="form-select" multiple>
            @foreach($roles as $role)
              <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check-lg"></i> Guardar
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
      </form>
    </div>
  </div>
</div>
@endsection
