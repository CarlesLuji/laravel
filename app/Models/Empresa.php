<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;   // 👈  IMPORTA el trait
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;   // 👈  Trae el trait dentro de la clase

    protected $fillable = [
        'nombre',
        'direccion',
        'n_empresa_conta',
        'n_empresa_ips',
        'cif',
    ];
}
