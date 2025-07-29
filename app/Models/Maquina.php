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
        'maquina_origin_id',
        'fecha_alta',
        'fecha_baja',
    ];

    /**
     * Relación con el contrato al que pertenece esta máquina
     */
    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    /**
     * Relación con el modelo de máquina
     */
    public function modelo()
    {
        return $this->belongsTo(ModeloMaquina::class, 'modelo_maquina_id');
    }

    /**
     * La máquina original a la que este kit pertenece (si aplica)
     */
    public function maquinaOriginal()
    {
        return $this->belongsTo(Maquina::class, 'maquina_origin_id');
    }

    /**
     * Kits que han sido instalados en esta máquina a lo largo del tiempo
     */
    public function kitsInstalados()
    {
        return $this->hasMany(Maquina::class, 'maquina_origin_id');
    }
}
