@extends('layouts.adminlte')

@section('content')
<p></p>
 
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
        <table id="maquinas-table" class="table table-striped table-bordered align-middle text-nowrap">
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
            <tfoot class="table-light">
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
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@push('styles')
<style>
  .btn-export-custom {
    background-color: #fff !important;
    color: #b12545 !important;
    border: 1px solid #b12545 !important;
    box-shadow: none;
    margin-left: 0.25rem;
    margin-right: 0.25rem;
  }

  .btn-export-custom:hover {
    background-color: #f9f9f9 !important;
    color: #b12545 !important;
  }
</style>
@endpush
@push('scripts')
<script>
  $(document).ready(function () {
    // Crear inputs de filtro en el footer (excepto columna Acciones)
    $('#maquinas-table tfoot th').each(function () {
      var title = $(this).text().trim();
      if (title && title.toLowerCase() !== 'acciones') {
        $(this).html('<input type="text" class="form-control form-control-sm" placeholder=" ' + title + '" />');
      } else {
        $(this).html('');
      }
    });

    var table = $('#maquinas-table').DataTable({
      language: {
        url: '{{ asset("js/datatables/i18n/es-ES.json") }}'
      },
      responsive: true,
      pageLength: 10,
      pagingType: "simple_numbers",

      dom:
        "<'row align-items-center mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>" +
        "<'row'<'col-12'tr>>" +
        "<'row mt-3'<'col-md-6'i><'col-md-6'p>>",

      buttons: [
        {
          extend: 'copy',
          text: '<i class="bi bi-clipboard"></i> Copiar',
          className: 'btn btn-sm btn-export-custom'
        },
        {
          extend: 'excel',
          text: '<i class="bi bi-file-earmark-excel"></i> Excel',
          className: 'btn btn-sm btn-export-custom'
        },
        {
          extend: 'csv',
          text: '<i class="bi bi-filetype-csv"></i> CSV',
          className: 'btn btn-sm btn-export-custom'
        },
        {
          extend: 'print',
          text: '<i class="bi bi-printer"></i> Imprimir',
          className: 'btn btn-sm btn-export-custom'
        }
      ],

      // Inicializar filtros por columna
      initComplete: function () {
        this.api().columns().every(function () {
          var column = this;
          $('input', column.footer()).on('keyup change clear', function () {
            if (column.search() !== this.value) {
              column.search(this.value).draw();
            }
          });
        });
      },

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
