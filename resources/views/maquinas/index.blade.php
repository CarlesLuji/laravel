@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Máquinas</h1>
    </div>
    <div class="col text-end">
      @can('crear maquinas')
      <a href="{{ route('maquinas.create') }}" class="btn btn-sm btn-outline-danger">
        <i class="bi bi-plus-lg"></i> Crear Máquina
      </a>
      @endcan
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="maquinas-table" class="table table-striped table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>Nº Máquina IPS</th>
              <th>Modelo</th>
              <th>Nº Serie</th>
              <th>Contrato</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($maquinas as $maquina)
              <tr>
                <td>{{ $maquina->numero_maquina_ips }}</td>
                <td>{{ $maquina->modelo?->marca }} {{ $maquina->modelo?->modelo }}</td>
                <td>{{ $maquina->numero_serie }}</td>
                <td>{{ $maquina->contrato?->numero_contrato ?? '—' }}</td>
                <td>
                  @can('editar maquinas')
                  <a href="{{ route('maquinas.edit', $maquina) }}" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-pencil"></i> Editar
                  </a>
                  @endcan
                  @can('eliminar maquinas')
                  <form action="{{ route('maquinas.destroy', $maquina) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta máquina?')">
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
  $(document).ready(function () {
    $('#maquinas-table').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
      },
      responsive: true,
      pageLength: 10,
      pagingType: "simple_numbers",
      drawCallback: function () {
        $('.dataTables_paginate ul.pagination li a')
          .removeClass('page-link')
          .addClass('btn btn-sm btn-outline-danger mx-1');
        $('.dataTables_paginate ul.pagination li').removeClass('page-item');
      }
    });
  });
</script>
@endpush
