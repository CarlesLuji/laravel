@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h1 class="h3">Contratos</h1>
    </div>
    <div class="col text-end">
      @can('crear contratos')
      <a href="{{ route('contratos.create') }}" class="btn btn-sm btn-outline-danger">
        <i class="bi bi-plus-lg"></i> Crear Contrato
      </a>
      @endcan
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="contratos-table" class="table table-striped table-bordered align-middle text-nowrap">
          <thead class="table-light">
            <tr>
              <th>Emp</th>
              <th>Prov</th>
              <th>Nº Cont</th>
              <th>Nº Maq</th>
              <th>Máquinas</th>
              <th>Kits instalados</th>
              <th>F.Firma</th>
              <th>F.Inicio</th>
              <th>Vto</th>
              <th>(meses)</th>
              <th>I Mensual</th>
              <th>I Iva</th>
              <th>I Cuota</th>
              <th>I Total</th>
              <th style="text-align:right; color:red;">Valor R</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($contratos as $contrato)
              <tr>
                <td style="text-align:left;">{{ $contrato->empresa->alias }}</td>
                <td style="text-align:left;">{{ $contrato->proveedor->alias }}</td>
                <td contenteditable="true" class="editable" data-id="{{ $contrato->id }}" data-column="numero_contrato" style="text-align:center;">{{ $contrato->numero_contrato }}</td>
 @php
  // Contamos las máquinas que NO son kits (es decir, sin origen)
  $maquinasReales = $contrato->maquinas->whereNull('maquina_origin_id')->count();
@endphp
<td style="text-align:center;">
  {{ $maquinasReales }}
</td>
               
                {{-- Máquinas --}}
<td style="white-space: normal; max-width: 200px;" data-search="{{ $contrato->maquinas->pluck('numero_maquina_ips')->join(' ') }}">
  @if($contrato->maquinas->isEmpty())
    <span class="text-muted">—</span>
  @else
    @foreach($contrato->maquinas as $maquina)
      <div style="margin-bottom: 4px;"> {{-- Permiso PDF --}}
    @php
      $archivoPermiso = 'storage/maquinas/' . $maquina->numero_maquina_ips . '.pdf';
    @endphp
    @if (file_exists(public_path($archivoPermiso)))
      <a href="{{ asset($archivoPermiso) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Ver permiso PDF">
        <i class="bi bi-file-earmark-pdf-fill"></i>
      </a>
    @else
      <span class="text-muted" title="Sin permiso PDF">
       
      </span>
    @endif

        <span class="badge" style="background:#f5f5f5; color:#555;">
          {{ $maquina->numero_maquina_ips }}
          <small style="color:#888;">
            ({{ Str::limit($maquina->modelo?->modelo, 10, '') }})
          </small>
        </span>
        
      </div>
    @endforeach
  @endif
</td>

{{-- Kits instalados (alineados) --}}
<td style="white-space: normal; max-width: 200px;" data-search="
  {{ $contrato->maquinas->flatMap(function($maquina){
      return $maquina->kitsInstalados->pluck('numero_maquina_ips');
  })->join(' ') }}">
  @if($contrato->maquinas->isEmpty())
    <span class="text-muted">—</span>
  @else
    @foreach($contrato->maquinas as $maquina)
      @php
        $kit = $maquina->kitsInstalados->first(); // asumimos 1 kit por máquina
      @endphp
      <div style="margin-bottom: 4px;">
        @if($kit)
          <span class="badge" style="background:#b12545; color:#fff;">
            {{ $kit->numero_maquina_ips }}
            <small style="color:#f9f9f9;">
              ({{ Str::limit($kit->modelo?->modelo, 10, '') }})
            </small>
          </span>
        @else
          <span class="text-muted">—</span>
        @endif
      </div>
    @endforeach
  @endif
</td>

                <td style="text-align:center; background-color: #fff !important;
    color: #b12545 !important;">{{ \Carbon\Carbon::parse($contrato->fecha_firma)->format('Y-m-d') }}</td>
                <td style="text-align:center;">{{ \Carbon\Carbon::parse($contrato->fecha_inicio)->format('Y-m-d') }}</td>
                <td style="text-align:center;">{{ \Carbon\Carbon::parse($contrato->fecha_vencimiento)->format('Y-m-d') }}</td>
                <td contenteditable="true" class="editable" data-id="{{ $contrato->id }}" data-column="duracion_meses" style="text-align:center;">{{ $contrato->duracion_meses }}</td>
                <td contenteditable="true" class="editable" data-id="{{ $contrato->id }}" data-column="importe_mensual" style="text-align:right;">{{ number_format($contrato->importe_mensual, 2) }}</td>
                <td contenteditable="true" class="editable" data-id="{{ $contrato->id }}" data-column="iva" style="text-align:right;">{{ number_format($contrato->iva * $contrato->importe_mensual / 100, 2) }}</td>
                <td style="text-align:right;">{{ number_format($contrato->importe_mensual + ($contrato->iva * $contrato->importe_mensual / 100), 2) }}</td>
                <td style="text-align:right;">{{ number_format($contrato->total_contrato, 2) }}</td>
                <td contenteditable="true" class="editable" data-id="{{ $contrato->id }}" data-column="valor_residual" style="text-align:right; color:red;">
                    {{ number_format($contrato->valor_residual, 2) }}
                </td>
                
                {{-- Acciones --}}
                <td>
                  @can('editar contratos')
                  <a href="{{ route('contratos.edit', $contrato) }}" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-pencil"></i>
                  </a>
                  @endcan

                  {{-- Botón PDF --}}
                  @if ($contrato->ruta_pdf)
                    <a href="{{ asset('storage/contratos/' . $contrato->ruta_pdf) }}" 
                       class="btn btn-sm btn-outline-success" 
                       target="_blank" 
                       title="Ver contrato PDF">
                      <i class="bi bi-file-earmark-pdf"></i>
                    </a>
                  @else
                    <a href="#" 
                       class="btn btn-sm btn-outline-danger disabled-link" 
                       title="Contrato sin PDF">
                      <i class="bi bi-file-earmark-pdf"></i>
                    </a>
                  @endif

                  @can('eliminar contratos')
                  <form action="{{ route('contratos.destroy', $contrato) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este contrato?')">
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
              <th>Emp</th>
              <th>Prov</th>
              <th>Nº Cont</th>
              <th>Nº Maq</th>
              <th>Máquinas</th>
              <th>Kits instalados</th>
              <th>F.Firma</th>
              <th>F.Inicio</th>
              <th>Vto</th>
              <th>(meses)</th>
              <th>I Mensual</th>
              <th>I Iva</th>
              <th>I Cuota</th>
              <th>I Total</th>
              <th style="text-align:right; color:red;">Valor R</th>
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
    border: 1px solid rgba(192, 172, 176, 1) !important;
    box-shadow: none;
    margin-left: 0.25rem;
    margin-right: 0.25rem;
  }
  .btn-export-custom:hover {
    background-color: #f9f9f9 !important;
    color: #b12545 !important;
  }
  table.dataTable td, table.dataTable th {
    white-space: nowrap;
    width: 1%;
  }
  /* Botón rojo deshabilitado */
  .disabled-link {
    pointer-events: none;
    opacity: 0.6;
  }
</style>
@endpush

@push('scripts')
<script>
  $(document).ready(function () {
    // Crear inputs de filtro en el footer
    $('#contratos-table tfoot th').each(function () {
      var title = $(this).text().trim();
      if (title && title.toLowerCase() !== 'acciones') {
        $(this).html('<input type="text" class="form-control form-control-sm" placeholder="' + title + '" />');
      } else {
        $(this).html('');
      }
    });

    var table = $('#contratos-table').DataTable({
      autoWidth: true,
      scrollX: false,
      columnDefs: [
        { targets: "_all", className: "nowrap" }
      ],
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
      },
      responsive: true,
      pageLength: 10,
      pagingType: "simple_numbers",
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
      },
      drawCallback: function () {
        $('.dataTables_paginate ul.pagination li a')
          .removeClass('page-link')
          .addClass('btn btn-sm btn-outline-danger mx-1');
        $('.dataTables_paginate ul.pagination li').removeClass('page-item');
      }
    });

    // Inline edit
    $('#contratos-table tbody').on('dblclick', '.editable', function () {
      var originalContent = $(this).text().trim();
      var input = $('<input type="text" class="form-control form-control-sm">').val(originalContent);
      var cell = $(this);
      cell.html(input);
      input.focus();

      input.on('blur', function () {
        var newValue = $(this).val().trim();
        var id = cell.data('id');
        var column = cell.data('column');

        if (newValue === originalContent) {
          cell.text(originalContent);
          return;
        }

        $.ajax({
          url: '{{ url("/contratos/update-inline") }}',
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            id: id,
            column: column,
            value: newValue
          },
          success: function (response) {
            if (response.success) {
              cell.text(newValue);
            } else {
              alert("Error al actualizar: " + response.message);
              cell.text(originalContent);
            }
          },
          error: function () {
            alert("Error de servidor al intentar actualizar.");
            cell.text(originalContent);
          }
        });
      });

      input.on('keydown', function (e) {
        if (e.key === 'Enter') {
          $(this).blur();
        }
      });
    });
  });
</script>
@endpush
