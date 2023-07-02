<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expediente_archivos', function (Blueprint $table) {
            $table->id('exar_id');
            $table->enum('exar_tipo', ['PRINCIPAL', 'ANEXO', 'ADJUNTO', 'RESPUESTA'])->nullable();
            $table->string('exar_url', 120)->nullable();
            $table->unsignedBigInteger('exar_expe_id');
            $table->unsignedBigInteger('exar_arch_id');
            $table->unsignedBigInteger('exar_tram_id')->nullable();

            $table->timestamps();
            $table->foreign('exar_expe_id')->references('expe_id')->on('expedientes');
            $table->foreign('exar_arch_id')->references('arch_id')->on('archivos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expediente_archivos');
    }
};
