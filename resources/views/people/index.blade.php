@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Personas</h1>
    </div>
    <div class="col text-end">
      @can('crear people')<p>
        <a href="{{ route('people.create') }}" class="btn btn-sm btn-outline-danger">
          <i class="bi bi-plus-lg"></i> Crear Persona
        </a>
      @endcan
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <table id="people-table" class="table table-striped table-bordered align-middle text-nowrap">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Persona</th>
            <th>Nivel</th>
            <th>Departamento</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($people as $person)
            <tr>
              <td>{{ $person->id }}</td>
              <td>{{ $person->Persona }}</td>
              <td>{{ $person->Nivel }}</td>
              <td>{{ $person->Dpto }}</td>
              <td>
                @can('editar people')
                  <a href="{{ route('people.edit', $person) }}" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-pencil"></i>
                  </a>
                @endcan
                @can('eliminar people')
                  <form action="{{ route('people.destroy', $person) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta persona?')">
                      <i class="bi bi-trash"></i>
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
            <th>Persona</th>
            <th>Nivel</th>
            <th>Departamento</th>
            <th>Acciones</th>
          </tr>
        </tfoot>
      </table>
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
    margin: 0 0.25rem;
  }
  .btn-export-custom:hover {
    background-color: #f9f9f9 !important;
  }
</style>
@endpush

@push('scripts')
<script>
  $(document).ready(function () {
    // Agregar input de filtro a cada columna del footer
    $('#people-table tfoot th').each(function () {
      var title = $(this).text();
      if (title !== 'Acciones') {
        $(this).html('<input type="text" class="form-control form-control-sm" placeholder="' + title + '" />');
      } else {
        $(this).html('');
      }
    });

    var table = $('#people-table').DataTable({
      language: {
        url: '{{ asset("js/datatables/i18n/es-ES.json") }}'
      },
      responsive: true,
      pageLength: 10,
      pagingType: "simple_numbers",
      dom:
        "<'row mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>" +
        "<'row'<'col-12'tr>>" +
        "<'row mt-3'<'col-md-6'i><'col-md-6'p>>",
      buttons: [
        { extend: 'copy', text: '<i class="bi bi-clipboard"></i> Copiar', className: 'btn btn-sm btn-export-custom' },
        { extend: 'excel', text: '<i class="bi bi-file-earmark-excel"></i> Excel', className: 'btn btn-sm btn-export-custom' },
        { extend: 'csv', text: '<i class="bi bi-filetype-csv"></i> CSV', className: 'btn btn-sm btn-export-custom' },
        { extend: 'print', text: '<i class="bi bi-printer"></i> Imprimir', className: 'btn btn-sm btn-export-custom' }
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
        // Aplicar estilos personalizados a la paginación
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


