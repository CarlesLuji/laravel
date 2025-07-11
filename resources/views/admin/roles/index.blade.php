@extends('layouts.adminlte')

@section('content')<p></p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Roles</h1>
    </div>
    <div class="col text-end">
      <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Crear Rol
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="roles-table" class="table table-striped table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>Nombre</th>
              <th>Permisos</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($roles as $role)
              <tr>
                <td>{{ $role->name }}</td>
                <td>{{ $role->permissions->pluck('name')->join(', ') }}</td>
                <td>
                  <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                  </a>
                  <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este rol?')">
                      <i class="bi bi-trash"></i> Eliminar
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $('#roles-table').DataTable({
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
      },
      responsive: true,
      pageLength: 10
    });
  });
</script>
@endpush
