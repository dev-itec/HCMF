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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->string('identificador')->unique();
            $table->string('clave');
            $table->string('nombre_completo');
            $table->string('genero')->nullable();
            $table->string('cargo')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->string('relacion')->nullable();
            $table->json('tipo_denuncia')->nullable(); // Almacenar múltiples tipos
            $table->text('detalles_incidente')->nullable();
            $table->date('fecha_exacta')->nullable();
            $table->date('fecha_aproximada')->nullable();
            $table->time('hora_incidente')->nullable();
            $table->text('lugar_incidente')->nullable();
            $table->text('descripcion_caso')->nullable();
            $table->string('personas_involucradas')->nullable();
            $table->text('testigos')->nullable();
            $table->string('como_se_entero')->nullable();
            $table->string('como_se_entero_otro')->nullable();
            $table->json('impacto_empresa')->nullable(); // Almacenar múltiples valores
            $table->string('impacto_empresa_otro')->nullable();
            $table->json('impacto_personal')->nullable(); // Almacenar múltiples valores
            $table->string('impacto_personal_otro')->nullable();
            $table->json('accion_esperada')->nullable(); // Almacenar múltiples valores
            $table->string('accion_esperada_otra')->nullable();
            $table->json('evidencia')->nullable(); // Para almacenar múltiples archivos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
