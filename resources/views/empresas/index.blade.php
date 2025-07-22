@extends('layouts.adminlte')

@section('content')<p></p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Empresas</h1>
    </div>
    <div class="col text-end">
      @can('crear empresas')
        <a href="{{ route('empresas.create') }}" class="btn btn-sm btn-outline-danger">
          <i class="bi bi-plus-lg"></i> Crear Empresa
        </a>
      @endcan
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="empresas-table" class="table table-striped table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>Nombre</th>
              <th>Dirección</th>
              <th>CIF</th>
              <th>Cód. Contable</th>
              <th>Cód. IPS</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($empresas as $empresa)
              <tr>
                <td>{{ $empresa->nombre }}</td>
                <td>{{ $empresa->direccion }}</td>
                <td>{{ $empresa->cif }}</td>
                <td>{{ $empresa->n_empresa_conta }}</td>
                <td>{{ $empresa->n_empresa_ips }}</td>
                <td>
                  @can('editar empresas')
                    <a href="{{ route('empresas.edit', $empresa) }}" class="btn btn-sm btn-outline-danger">
                      <i class="bi bi-pencil"></i> Editar
                    </a>
                  @endcan
                  @can('eliminar empresas')
                    <form action="{{ route('empresas.destroy', $empresa) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta empresa?')">
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
    $('#empresas-table').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
      },
      responsive: true,
      pageLength: 10,
      pagingType: "simple_numbers",
      drawCallback: function() {
        $('.dataTables_paginate ul.pagination li a').removeClass('page-link').addClass('btn btn-sm btn-outline-danger mx-1');
        $('.dataTables_paginate ul.pagination li').removeClass('page-item');
      }
    });
  });
</script>
@endpush
