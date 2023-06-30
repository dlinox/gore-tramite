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
        Schema::create('tramite_archivos', function (Blueprint $table) {
            $table->id('trar_id');
            $table->enum('trar_tipo', ['PRINCIPAL', 'ANEXO', 'ADJUNTO', 'RESPUESTA'])->nullable();
            $table->string('trar_url', 120)->nullable();
            $table->unsignedBigInteger('trar_tram_id');
            $table->unsignedBigInteger('trar_arch_id');
            $table->timestamps();
            $table->foreign('trar_tram_id')->references('tram_id')->on('tramites');
            $table->foreign('trar_arch_id')->references('arch_id')->on('archivos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramite_archivos');
    }
};
