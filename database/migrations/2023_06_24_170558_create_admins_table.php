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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('ofic_id');
            $table->unsignedBigInteger('pers_id')->unique();
            $table->string('ofic_name')->nullable();
            $table->string('rol_name')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('pers_id')->references('pers_id')->on('personas');
            $table->foreign('ofic_id')->references('ofic_id')->on('oficinas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
