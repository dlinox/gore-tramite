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
        Schema::create('personas', function (Blueprint $table) {
            $table->id('pers_id');
            $table->string('pers_nombre', 100);
            $table->string('pers_paterno', 60);
            $table->string('pers_materno', 60);
            $table->date('pers_fecha_nacimiento')->nullable();
            $table->char('pers_nro_documento', 12)->unique();
            $table->enum('pers_tipo_documento', ['RUC', 'DNI', 'CE'])->default('DNI');
            $table->string('pers_ugigeo')->nullable();
            $table->string('pers_direccion')->nullable();
            $table->char('pers_celular')->nullable()->unique();
            $table->string('pers_correo')->nullable()->unique();
            $table->string('pers_pais')->default('Perú');
            $table->boolean('pers_estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
