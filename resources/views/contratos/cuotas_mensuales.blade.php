@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
    <h2>Informe de Cuotas Mensuales (Solo Pendientes)</h2>
   <div class="table-responsive">
        <table id="tabla-cuotas" class="table table-striped table-bordered align-middle text-nowrap">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Proveedor</th>
                <th>Nº Contrato</th>
                <th>Mes</th>
                <th>Importe Mensual</th>
                <th>IVA</th>
                <th>Total Mensual</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cuotas as $cuota)
                <tr>
                    <td>{{ $cuota['empresa'] }}</td>
                    <td>{{ $cuota['proveedor'] }}</td>
                    <td>{{ $cuota['numero_contrato'] }}</td>
                    <td>{{ $cuota['mes'] }}</td>
                    <td class="text-end">{{ $cuota['importe_mensual'] }}</td>
                    <td class="text-end">{{ $cuota['iva'] }}</td>
                    <td class="text-end">{{ $cuota['total_mensual'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Empresa</th>
                <th>Proveedor</th>
                <th>Nº Contrato</th>
                <th>Mes</th>
                <th>Importe Mensual</th>
                <th>IVA</th>
                <th>Total Mensual</th>
            </tr>
        </tfoot>

    </table>
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
    $('#tabla-cuotas tfoot th').each(function () {
      var title = $(this).text().trim();
      if (title && title.toLowerCase() !== 'acciones') {
        $(this).html('<input type="text" class="form-control form-control-sm" placeholder=" ' + title + '" />');
      } else {
        $(this).html('');
      }
    });

    var table = $('#tabla-cuotas').DataTable({
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
