<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rdor extends Model
{
    protected $connection = 'mysql'; // conexión definida en config/database.php
    protected $table = 'rdors';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['nombre', 'codigo'];
}
