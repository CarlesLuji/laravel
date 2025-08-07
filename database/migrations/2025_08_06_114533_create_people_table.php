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
    Schema::create('people', function (Blueprint $table) {
        $table->id();
        $table->string('Persona', 50)->nullable()->default('0');
        $table->integer('Nivel')->nullable()->default(4);
        $table->string('Dpto', 50)->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('people');
}

};
