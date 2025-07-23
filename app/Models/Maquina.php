<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato_id',
        'modelo_maquina_id',
        'numero_maquina_ips',
        'numero_serie',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    public function modelo()
    {
        return $this->belongsTo(ModeloMaquina::class, 'modelo_maquina_id');
    }
}
