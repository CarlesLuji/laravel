@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Cuotas Ptes</h1>
    </div>
    <div class="col text-end">
     
    </div>
  </div>

  <div class="card">
    <div class="card-body">
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

<div class="card mt-4">
  <div class="card-body">
    <div class="table-responsive">
      <table id="tabla-cuotas-matriz" class="table table-striped table-bordered align-middle text-nowrap">
        <thead>
          <tr>
            <th>Empresa</th>
            <th>Proveedor</th>
            <th>Nº Contrato</th>
            <th>Total Contrato</th>
            <th>Total Año {{ $anioActual }}</th>
            @foreach($mesesDisponibles as $mes)
              <th>{{ $mes }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($cuotasMatriz as $fila)
            <tr>
              <td>{{ $fila['empresa'] }}</td>
              <td>{{ $fila['proveedor'] }}</td>
              <td>{{ $fila['numero_contrato'] }}</td>
              <td class="text-end">{{ number_format($fila['total_contrato'], 2, ',', '.') }}</td>
              <td class="text-end">{{ number_format($fila['total_anio'], 2, ',', '.') }}</td>
              @foreach($mesesDisponibles as $mes)
                <td class="text-end">
                  @if(!is_null($fila[$mes]))
                    {{ number_format($fila[$mes], 2, ',', '.') }}
                  @else
                    —
                  @endif
                </td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>Empresa</th>
            <th>Proveedor</th>
            <th>Nº Contrato</th>
            <th>Total Contrato</th>
            <th>Total Año {{ $anioActual }}</th>
            @foreach($mesesDisponibles as $mes)
              <th>{{ $mes }}</th>
            @endforeach
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
    box-shadow: none;
    margin-left: 0.25rem;
    margin-right: 0.25rem;
  }

  .btn-export-custom:hover {
    background-color: #f9f9f9 !important;
    color: #b12545 !important;
  }
  /* 💡 NUEVO: clase para la fila de subtotal */
 tr.subtotal-row {
  background-color: red !important; /* ✅ Color marrón oscuro válido */
  color: white !important;              /* ✅ Texto blanco para contraste */
  font-weight: bold;
}
  table#tabla-cuotas tbody tr.subtotal-row {
  background-color: #918755ff!important;
}

</style>
@endpush

@push('scripts')
<script>
  $(document).ready(function () {
    // Crear inputs de filtro en el footer
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
      ordering: true, // evita que se mezclen los subtotales
      pagingType: "simple_numbers",
      lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
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
        var api = this.api();
        var rows = api.rows({ page: 'current' }).nodes();
        var rowCount = rows.length;

        var subtotales = {};
        var ultimaFilaEmpresa = {};

        // Eliminar subtotales anteriores
        $(rows).filter('.subtotal-row').remove();

        // Recorrer las filas visibles
        for (let i = 0; i < rowCount; i++) {
          const $row = $(rows[i]);
          const cells = $row.find('td');

          const empresa = $(cells[0]).text().trim();
          const totalStr = $(cells[6]).text().trim();
          const total = parseFloat(totalStr.replace(/\./g, '').replace(',', '.')) || 0;

          if (!subtotales[empresa]) {
            subtotales[empresa] = 0;
          }

          subtotales[empresa] += total;
          ultimaFilaEmpresa[empresa] = i; // guardamos el índice de la última fila de esta empresa
        }

        // Insertar filas de subtotales
        Object.keys(subtotales).reverse().forEach(function (empresa) {
          const subtotal = subtotales[empresa];
          const index = ultimaFilaEmpresa[empresa];

          const subtotalFormatted = subtotal.toLocaleString('es-ES', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });

         const $subtotalRow = $(`
  <tr class="subtotal-row" style="background-color: #b12545 !important;">
    <td colspan="5"style="background-color: #ac9b9fff !important;">${empresa} - Subtotal</td>
    <td style="background-color: #ac9b9fff !important;"></td>
    <td class="text-end"style="background-color: #ac9b9fff !important;">${subtotalFormatted}</td>
  </tr>
`);

          // Insertar después de la última fila de la empresa
          $(rows[index]).after($subtotalRow);
        });

        // Reestilizar paginación
        $('.dataTables_paginate ul.pagination li a')
          .removeClass('page-link')
          .addClass('btn btn-sm btn-outline-danger mx-1');
        $('.dataTables_paginate ul.pagination li').removeClass('page-item');
      }
    });
  });
</script>
<script>

// Crear inputs de filtro solo para las 3 primeras columnas
$('#tabla-cuotas-matriz tfoot th').each(function (i) {
  if (i < 3) {
    var title = $(this).text().trim();
    $(this).html('<input type="text" class="form-control form-control-sm" placeholder=" ' + title + '" />');
  } else {
    $(this).html('');
  }
});

var table2 = $('#tabla-cuotas-matriz').DataTable({
  language: {
    url: '{{ asset("js/datatables/i18n/es-ES.json") }}'
  },
  responsive: true,
  pageLength: 10,
  ordering: true,
  pagingType: "simple_numbers",
  lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
  dom:
    "<'row align-items-center mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>" +
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
  }
});

</script>
@endpush



