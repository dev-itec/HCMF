<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResolucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resolucion', function (Blueprint $table) {
            $table->id(); // ID único para la resolución
            $table->unsignedBigInteger('denuncia_id'); // ID de la denuncia asociada
            $table->string('identificador'); // Identificador del caso
            $table->text('texto_resolucion'); // Texto de la resolución
            $table->string('pdf')->nullable(); // Ruta del archivo PDF asociado
            $table->timestamps(); // Timestamps para created_at y updated_at

            // Añadir la clave foránea
            $table->foreign('denuncia_id')->references('id')->on('answers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resolucion');
    }
}
