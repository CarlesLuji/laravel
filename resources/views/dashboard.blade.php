@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Bienvenido al Dashboard LTE</h1>
            <p><h3>Organización Jerárquica del sitio web</h3></p>
        </div>
    </div>

    <!-- Ejemplo de cajas -->
    <div class="row">
     <div style="background-color: #f8f9fa; padding: 1rem; border: 1px solid #ccc; border-radius: 5px; font-family: monospace; white-space: pre;">
<span style="color:red;font-style: italic;">Base: Laravel 12 + Breeze + AdminLTE 4 + Spatie + Maatwebsite Excel + Barryvdh PDF</span>
Repo: "master" : <a href="https://github.com/CarlesLuji/laravel.git" target="_blank"><i class="bi bi-github"></i></a>

Dependencias principales:
├── PHP: ^8.2
├── laravel/framework: ^12.0
├── laravel/breeze: ^2.3
├── almasaeed2010/adminlte: 4.0.0-beta3
├── spatie/laravel-permission: ^6.0
├── maatwebsite/excel: ^1.1
├── barryvdh/laravel-dompdf: ^3.1
├── laravel/tinker, sail, pint, pail
├── Testing: pest, mockery, collision, faker

Estructura del sitio:
├── Dashboard
│   ├── Dashboard 1          (/dashboard)
│   └── Dashboard 2          (/dashboard2)
├── Administración (solo admin)
│   ├── Usuarios             (/admin/users)
│   ├── Roles                (/admin/roles)
│   └── Permisos             (/admin/permissions)
├── Pages
│   ├── Page 1               (/page1)
│   └── Page 2               (/page2)
├── Settings                 (/settings)
└── Reports
    ├── Reports 1
    │   ├── Monthly
    │   └── Annual
    └── Reports 2
        ├── Monthly
        └── Annual

</div>


    </div>
</div>
@endsection
