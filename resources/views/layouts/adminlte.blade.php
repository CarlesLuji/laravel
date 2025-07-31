<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" media="print" onload="this.media='all'">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}">
  <!-- datatables --> 
  <link rel="stylesheet" href="https://datatables-cdn.com/1.13.8/css/dataTables.bootstrap5.min.css">
  <!-- datatables buttons--> 
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
  <style>
  input.form-control,
  select.form-select,
  textarea.form-control {
    border: 1px solid #b12545 !important;
    box-shadow: none;
  } /* Estilo personalizado para los botones DataTables */
  .dt-button.btn {
    background-color: #fff !important;
    color: #b12545 !important;
    border: 1px solid #b12545 !important;
    box-shadow: none;
    margin-left: 0.25rem;
    margin-right: 0.25rem;
  }

  .dt-button.btn:hover {
    background-color: #f9f9f9 !important;
    color: #b12545 !important;
  }

  /* Para asegurar el estilo activo también */
  .dt-button.btn:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(177, 37, 69, 0.25);
  }

</style>

@stack('styles')

</head>
<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
  <div class="app-wrapper">
    @include('layouts.partials.header')
    @include('layouts.partials.sidebar')

    <main class="app-main">
      @yield('content')
    </main>

    @include('layouts.partials.footer')
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
  <!-- datatables --> 
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- DataTables Core + Bootstrap 5 JS -->
<script src="https://datatables-cdn.com/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://datatables-cdn.com/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables buttons -->

  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>



@stack('scripts')
</body>
</html>
