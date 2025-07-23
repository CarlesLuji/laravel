<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contrato extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'proveedor_id',
        'numero_contrato',
        'fecha_inicio',
        'fecha_fin',
        'duracion_meses',
        'importe_mensual',
        'iva',
        'total_mensual',
        'total_contrato',
        'ruta_pdf',
    ];

    /**
     * Relación con Empresa
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Relación con Proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Relación con Maquinas (1 contrato puede tener muchas máquinas)
     */
    public function maquinas()
    {
        return $this->hasMany(Maquina::class);
    }
}
