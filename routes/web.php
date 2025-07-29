<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('layouts/admin', function () {
    return view('layouts.admin');
})->middleware(['auth', 'verified'])->name('admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});
use App\Http\Controllers\EmpresaController;

Route::middleware(['auth'])->group(function () {
    Route::resource('empresas', EmpresaController::class);
});
use App\Http\Controllers\ProveedorController;

Route::middleware(['auth'])->group(function () {
    Route::resource('proveedores', ProveedorController::class)->parameters([
        'proveedores' => 'proveedor',
    ]);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('contratos', \App\Http\Controllers\ContratoController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('modelos-maquina', App\Http\Controllers\ModeloMaquinaController::class)->parameters([
        'modelos-maquina' => 'modeloMaquina',
    ]);
});
use App\Http\Controllers\MaquinaController;

Route::middleware(['auth'])->group(function () {
    Route::resource('maquinas', MaquinaController::class);
});
// ruta para la edicion inline de datatables en el contrato
Route::post('/contratos/update-inline', [App\Http\Controllers\ContratoController::class, 'updateInline'])
    ->name('contratos.update-inline')
    ->middleware('auth');

