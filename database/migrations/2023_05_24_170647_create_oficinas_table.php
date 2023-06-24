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
        Schema::create('oficinas', function (Blueprint $table) {
            $table->id('ofic_id');
            $table->string('ofic_nombre', 200)->unique();
            $table->string('ofic_descripcion')->nullable();
            $table->char('ofic_ubigeo', 6)->nullable();
            $table->string('ofic_direccion')->nullable();
            $table->char('ofic_siglas', 15)->unique();
            $table->boolean('ofic_publico')->default(0);
            $table->boolean('ofic_estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oficinas');
    }
};
