@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Bienvenido al Dashboard LTE</h1>
            <p>Este es tu contenido principal.</p>
        </div>
    </div>

    <!-- Ejemplo de cajas -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>150</h3>
                    <p>New Orders</p>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
