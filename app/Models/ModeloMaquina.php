<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloMaquina extends Model
{
    use HasFactory;

    protected $table = 'modelos_maquina';

    protected $fillable = [
        'marca',
        'modelo',
        'codigo_modelo_ips',
    ];
}

