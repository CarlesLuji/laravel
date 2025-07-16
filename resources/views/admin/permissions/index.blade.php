@extends('layouts.adminlte')

@section('content')<p></p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Permisos</h1>
    </div>
    <div class="col text-end">
      <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-outline-danger">
        <i class="bi bi-plus-lg"></i> Crear Permiso
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="permissions-table" class="table table-striped table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>Nombre</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($permissions as $permission)
              <tr>
                <td>{{ $permission->name }}</td>
                <td>
                  <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-pencil"></i> Editar
                  </a>
                  <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este permiso?')">
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
    $('#permissions-table').DataTable({
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
