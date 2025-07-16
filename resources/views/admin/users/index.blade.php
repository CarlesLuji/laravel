@extends('layouts.adminlte')

@section('content')<p></p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Usuarios</h1>
    </div>
    <div class="col text-end">
      <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-outline-danger">
        <i class="bi bi-plus-lg"></i> Crear Usuario
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="users-table" class="table table-striped table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>Nombre</th>
              <th>Email</th>
              <th>Roles</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $u)
              <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->getRoleNames()->join(', ') }}</td>
                <td>
                  <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-pencil"></i> Editar
                  </a>
                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit"
      onclick="return confirm('¿Estás seguro de eliminar este usuario?')"
      class="btn btn-sm btn-danger shadow-sm d-inline-flex align-items-center gap-1"
      style="background: linear-gradient(135deg, #dc3545, #b12545); border: none;">
      <i class="bi bi-trash-fill"></i> Eliminar
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
    $('#users-table').DataTable({
      language: {
    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
  },
      responsive: true,
      pageLength: 10,
      pagingType: "simple_numbers",
  drawCallback: function() {
      // Quita clases que DataTables pone por defecto
      $('.dataTables_paginate ul.pagination li a').removeClass('page-link').addClass('btn btn-sm btn-outline-danger mx-1');
      // Opcional: ajusta <li> para eliminar bordes
      $('.dataTables_paginate ul.pagination li').removeClass('page-item');
    }
    });
  });
</script>
@endpush

