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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id('docu_id');
            $table->string('docu_nombre', 60)->unique();
            $table->string('docu_descripcion', 160)->nullable();
            $table->string('docu_plantilla', 160)->nullable();
            $table->boolean('docu_recurso')->default(1);
            $table->boolean('docu_activo')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
