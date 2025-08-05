@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Rdors</h1>
    </div>
    <div class="col text-end">
      @can('crear rdors')
      <a href="{{ route('rdors.create') }}" class="btn btn-sm btn-outline-danger">
        <i class="bi bi-plus-lg"></i> Crear Rdor
      </a>
      @endcan
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="rdors-table" class="table table-striped table-bordered align-middle text-nowrap">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Código</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($rdors as $rdor)
              <tr>
                <td>{{ $rdor->id }}</td>
                <td>{{ $rdor->nombre }}</td>
                <td>{{ $rdor->codigo }}</td>
                <td>
                  @can('editar rdors')
                  <a href="{{ route('rdors.edit', $rdor) }}" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-pencil"></i> Editar
                  </a>
                  @endcan
                  @can('eliminar rdors')
                  <form action="{{ route('rdors.destroy', $rdor) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este Rdor?')">
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
              <th>ID</th>
              <th>Nombre</th>
              <th>Código</th>
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
    $('#rdors-table tfoot th').each(function () {
      var title = $(this).text().trim();
      if (title && title.toLowerCase() !== 'acciones') {
        $(this).html('<input type="text" class="form-control form-control-sm" placeholder="' + title + '" />');
      } else {
        $(this).html('');
      }
    });

    var table = $('#rdors-table').DataTable({
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
