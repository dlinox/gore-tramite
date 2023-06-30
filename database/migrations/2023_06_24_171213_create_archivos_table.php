<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id('arch_id');
            $table->string('arch_nombre', 80);
            $table->string('arch_path');
            $table->char('arch_extencion', 8);
            $table->unsignedBigInteger('arch_tamanio');
            $table->string('arch_mimetype')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
