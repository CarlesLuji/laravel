<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people';

    protected $fillable = [
        'Persona',
        'Nivel',
        'Dpto'
    ];
}
