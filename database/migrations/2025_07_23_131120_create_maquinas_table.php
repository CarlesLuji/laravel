<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maquinas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contrato_id');
            $table->unsignedBigInteger('modelo_maquina_id');
            $table->unsignedBigInteger('maquina_origin_id')->nullable(); // Referencia si es un kit
            $table->string('numero_maquina_ips')->unique();
            $table->string('numero_serie')->nullable();
            $table->date('fecha_alta')->nullable();
            $table->date('fecha_baja')->nullable();
            $table->timestamps();

            $table->foreign('contrato_id')->references('id')->on('contratos')->onDelete('cascade');
            $table->foreign('modelo_maquina_id')->references('id')->on('modelos_maquina')->onDelete('restrict');
            $table->foreign('maquina_origin_id')->references('id')->on('maquinas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinas');
    }
};
