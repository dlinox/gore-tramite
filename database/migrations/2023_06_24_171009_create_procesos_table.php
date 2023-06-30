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
        Schema::create('procesos', function (Blueprint $table) {
            $table->id('proc_id');
            $table->string('proc_nombre')->unique();
            $table->string('proc_descripcion')->nullable();
            $table->unsignedBigInteger('proc_docu_id'); //FK
            $table->integer('proc_plazo')->nullable();
            $table->boolean('proc_activo')->default(1);
            $table->timestamps();
            $table->foreign('proc_docu_id')->references('docu_id')->on('documentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procesos');
    }
};
