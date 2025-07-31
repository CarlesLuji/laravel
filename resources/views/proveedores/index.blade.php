@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Proveedores</h1>
    </div>
    <div class="col text-end">
      @can('crear proveedores')
        <a href="{{ route('proveedores.create') }}" class="btn btn-sm btn-outline-danger">
          <i class="bi bi-plus-lg"></i> Crear Proveedor
        </a>
      @endcan
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="proveedores-table" class="table table-striped table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>Nombre</th>
              <th>Alias</th>
              <th>Cuenta Contable</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($proveedores as $proveedor)
              <tr>
                <td>{{ $proveedor->nombre }}</td>
                <td>{{ $proveedor->alias }}</td>
                <td>{{ $proveedor->cuenta_contable }}</td>
                <td>
                  @can('editar proveedores')
                    <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-sm btn-outline-danger">
                      <i class="bi bi-pencil"></i> Editar
                    </a>
                  @endcan

                  @can('eliminar proveedores')
                    <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">
                        <i class="bi bi-trash"></i> Eliminar
                      </button>
                    </form>
                  @endcan
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
    $('#proveedores-table').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
      },
      responsive: true,
      pageLength: 10,
      pagingType: "simple_numbers",
      drawCallback: function() {
        $('.dataTables_paginate ul.pagination li a')
          .removeClass('page-link')
          .addClass('btn btn-sm btn-outline-danger mx-1');
        $('.dataTables_paginate ul.pagination li')
          .removeClass('page-item');
      }
    });
  });
</script>
@endpush
