<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->string('numero_contrato')->nullable()->unique();
            $table->date('fecha_inicio');
            $table->date('fecha_vencimiento');
            $table->integer('duracion_meses');
            $table->decimal('importe_mensual', 10, 2);
            $table->decimal('iva', 5, 2);
            $table->decimal('total_mensual', 10, 2);
            $table->decimal('total_contrato', 12, 2)->storedAs('(importe_mensual + (importe_mensual * iva / 100)) * duracion_meses');
            $table->string('ruta_pdf')->nullable();
            $table->timestamps();

            // Restricción única por proveedor y número de contrato
            $table->unique(['proveedor_id', 'numero_contrato'], 'proveedor_contrato_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
