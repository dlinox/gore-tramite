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
        Schema::create('proceso_requisitos', function (Blueprint $table) {
            $table->id('prre_id');
            $table->string('prre_nombre');
            $table->string('prre_descripcion')->nullable();
            $table->enum('prre_tipo_archivo', ['PDF', 'WORD', 'ZIP']);
            $table->unsignedBigInteger('prre_proc_id');
            $table->boolean('prre_activo')->default(1);
            $table->timestamps();
            $table->foreign('prre_proc_id')->references('proc_id')->on('procesos')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proceso_requisitos');
    }
};
