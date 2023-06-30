<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('expedientes', function (Blueprint $table) {

            $table->id('expe_id');
            $table->char('expe_codigo', 17)->unique()->nullable(); //001-20230000001-T
            $table->char('expe_password', 10);

            $table->smallInteger('expe_origen')->default(0)->comment("0=EXTERNO 1=INTERNO");

            $table->integer('expe_numero')->nullable();
            $table->char('expe_periodo', 4);
            $table->char('expe_sigla', 20);
            $table->enum('expe_tipo', ['JEFATURA', 'PERSONAL', 'EXTERNO', 'TUPA'])->default('EXTERNO');
            $table->unique(['expe_numero', 'expe_periodo', 'expe_sigla', 'expe_tipo', 'expe_origen', 'expe_docu_id'], 'expe_numero_unique');

            $table->string('expe_asunto', 200);
            $table->string('expe_resumen')->nullable();
            $table->integer('expe_folios')->nullable();
            $table->text('expe_observacion')->nullable();
            $table->dateTime('expe_fecha_registro')->timestamps();
            $table->integer('expe_plazo')->nullable(); //se define en el proceso
            $table->enum('expe_remi_tipo', ['NATURAL', 'JURIDICA'])->default('NATURAL');

            $table->unsignedBigInteger('expe_docu_id'); //Documento
            $table->unsignedBigInteger('expe_esta_id'); //Estado del expediente [Borrado, Tramite, Observado, Finalizado ...]
            $table->unsignedBigInteger('expe_proc_id'); //Proseso
            $table->unsignedBigInteger('expe_admin_id')->nullable(); // Usuario que crea el expediente
            $table->unsignedBigInteger('expe_pers_id'); // *REMITENTE
            $table->unsignedBigInteger('expe_ofic_id')->nullable(); // *REMITENTE

            $table->timestamps();

            $table->foreign('expe_esta_id')->references('esta_id')->on('estados');
            $table->foreign('expe_proc_id')->references('proc_id')->on('procesos');
            $table->foreign('expe_docu_id')->references('docu_id')->on('documentos');
            $table->foreign('expe_admin_id')->references('id')->on('admins');
            $table->foreign('expe_pers_id')->references('pers_id')->on('personas');
            $table->foreign('expe_ofic_id')->references('ofic_id')->on('oficinas');

            //$table->char('expe_anio', 4);
            //$table->char('expe_area', 4)->nullable();
            //$table->string('expe_file', 25)->nullable();
            //$table->string('expe_token', 45)->nullable();
            //$table->string('expe_archivo', 100)->nullable(); //cambiar
            //$table->string('expe_archivo2', 100)->nullable();
            //$table->text('expe_anexos')->nullable();
            //$table->boolean('expe_esfirmado')->default(0);
            // $table->string('expe_firma_nombre')->nullable();
            //$table->string('expe_firma_emisor')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};
