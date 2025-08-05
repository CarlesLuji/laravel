<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRdorsTable extends Migration
{
    public function up()
    {
        Schema::create('rdors', function (Blueprint $table) {
            $table->increments('id');          // Clave primaria autoincremental
            $table->string('nombre');          // Campo 'nombre' como string
            $table->string('codigo')->unique(); // Campo 'codigo' único
        });
    }

    public function down()
    {
        Schema::dropIfExists('rdors');
    }
}
