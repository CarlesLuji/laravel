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
              <th>Empresa</th>
              <th>Proveedor</th>
              <th>Nº Contrato</th>
              <th>Fecha Inicio</th>
              <th>Vencimiento</th>
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
                <td style="text-align:left;">{{ $contrato->empresa->nombre }}</td>
                <td style="text-align:left;">{{ $contrato->proveedor->nombre }}</td>
                <td style="text-align:center;">{{ $contrato->numero_contrato }}</td>
                <td>{{ $contrato->fecha_inicio }}</td>
                <td>{{ $contrato->fecha_vencimiento }}</td>
                <td style="text-align:center;">{{ $contrato->duracion_meses }}</td>
                <td style="text-align:right;">{{ number_format($contrato->importe_mensual, 2) }} €</td>
                <td style="text-align:right;">{{ number_format($contrato->iva*$contrato->importe_mensual/100, 2) }} €</td>
                <td style="text-align:right;">{{ number_format($contrato->importe_mensual+($contrato->iva*$contrato->importe_mensual/100), 2) }} €</td>
                <td style="text-align:right;">{{ number_format($contrato->total_contrato, 2) }} €</td>
                <td style="text-align:right; color:red;">
    {{ number_format($contrato->valor_residual, 2) }} €
</td>
                <td>
                  @can('editar contratos')
                  <a href="{{ route('contratos.edit', $contrato) }}" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-pencil"></i> Editar
                  </a>
                  @endcan
                    @if ($contrato->ruta_pdf)
    <a href="{{ asset('storage/contratos/' . $contrato->ruta_pdf) }}" 
       class="btn btn-sm btn-outline-secondary" 
       target="_blank" 
       title="Ver contrato PDF">
        <i class="bi bi-file-earmark-pdf"></i> PDF
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
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $('#contratos-table').DataTable({
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
        $('.dataTables_paginate ul.pagination li').removeClass('page-item');
      }
    });
  });
</script>
@endpush
