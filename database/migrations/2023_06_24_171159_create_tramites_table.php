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
        Schema::create('tramites', function (Blueprint $table) {
            $table->id('tram_id');
            $table->dateTime('tram_fecha_registro')->nullable();
            $table->boolean('tram_notificar')->default(0);
            $table->dateTime('tram_fecha_recibido')->nullable();
            $table->dateTime('tram_fecha_tramitado')->nullable();
            $table->char('tram_periodo', 4)->nullable(); //!se optiene del expediente
            $table->text('tram_observacion')->nullable();

            $table->unsignedBigInteger('tram_tram_padre')->nullable();
            $table->unsignedBigInteger('tram_expe_id');
            $table->unsignedBigInteger('tram_ofic_ini')->nullable();
            $table->unsignedBigInteger('tram_ofic_fin')->nullable();
            $table->unsignedBigInteger('tram_admin_ini')->nullable();
            $table->unsignedBigInteger('tram_admin_fin')->nullable();
            $table->unsignedBigInteger('tram_acci_id')->nullable();
            $table->unsignedBigInteger('tram_esta_id')->nullable();
            $table->unsignedBigInteger('tram_docu_id')->nullable(); //!no se llena

            $table->index('tram_expe_id');
            $table->index('tram_ofic_ini');
            $table->index('tram_ofic_fin');
            $table->index('tram_admin_ini');
            $table->index('tram_admin_fin');
            $table->index('tram_acci_id');

            $table->foreign('tram_expe_id')->references('expe_id')->on('expedientes');
            $table->foreign('tram_ofic_ini')->references('ofic_id')->on('oficinas');
            $table->foreign('tram_ofic_fin')->references('ofic_id')->on('oficinas');
            $table->foreign('tram_admin_ini')->references('id')->on('admins');
            $table->foreign('tram_admin_fin')->references('id')->on('admins');
            $table->foreign('tram_acci_id')->references('acci_id')->on('acciones');
            $table->foreign('tram_esta_id')->references('esta_id')->on('estados');
            $table->foreign('tram_tram_padre')->references('tram_id')->on('tramites');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramites');
    }
};
