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
              <th>Kit Asociado</th>
              <th>Kits instalados</th>
              <th>Alta</th>
              <th>Baja</th>
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
                  @if ($maquina->maquinaOriginal)
                    {{ $maquina->maquinaOriginal->numero_maquina_ips }}
                  @else
                    <span class="text-muted">—</span>
                  @endif
                </td>
                 <td>
                  @if($maquina->kitsInstalados->isEmpty())
                    <span class="text-muted">—</span>
                  @else
                    @foreach($maquina->kitsInstalados as $kit)
                      <span class="badge bg-danger text-white">{{ $kit->numero_maquina_ips }}</span>
                    @endforeach
                  @endif
                </td>
                <td>{{ $maquina->fecha_alta ? \Carbon\Carbon::parse($maquina->fecha_alta)->format('d/m/Y') : '—' }}</td>
                <td>{{ $maquina->fecha_baja ? \Carbon\Carbon::parse($maquina->fecha_baja)->format('d/m/Y') : '—' }}</td>
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
        url: '{{ asset("js/datatables/i18n/es-ES.json") }}'
      },
      responsive: true,
      pageLength: 10,
      pagingType: "simple_numbers",

      // Mostrar selector y búsqueda uno al lado del otro
      dom: "<'row mb-3'<'col-md-6'l><'col-md-6'f>>" +
           "<'row'<'col-12'tr>>" +
           "<'row mt-3'<'col-md-6'i><'col-md-6'p>>",

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
