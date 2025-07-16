@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Bienvenido al Dashboard LTE</h1>
            <p><h3>Organización Jerarquica del sitio web</h3></p>
        </div>
    </div>

    <!-- Ejemplo de cajas -->
    <div class="row">
      <div style="background-color: #f8f9fa; padding: 1rem; border: 1px solid #ccc; border-radius: 5px; font-family: monospace; white-space: pre;">
Portal Empresa (Laravel 12 + Breeze + AdminLTE 4)
├── Dashboard
│   ├── Dashboard 1 (/dashboard)
│   └── Dashboard 2 (/dashboard2)
├── Administración (solo admin)
│   ├── Usuarios (/admin/users)
│   ├── Roles (/admin/roles)
│   └── Permisos (/admin/permissions)
├── Pages
│   ├── Page 1 (/page1)
│   └── Page 2 (/page2)
├── Settings (/settings)
├── Reports
│   ├── Reports 1 (Monthly, Annual)
│   └── Reports 2 (Monthly, Annual)
</div>

    </div>
</div>
@endsection
