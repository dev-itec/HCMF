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
            Schema::create('questions', function (Blueprint $table) {
                $table->id();
                $table->string('label'); // Nombre del campo (Ej. "Nombre completo")
                $table->string('name');  // Nombre en el formulario (Ej. "nombre_completo")
                $table->string('type');  // Tipo de campo (text, date, select, checkbox)
                $table->json('options')->nullable(); // Opciones para selects o checkboxes
                $table->unsignedInteger('order')->default(0); // Orden de aparición
                $table->boolean('required')->default(false); // Si el campo es obligatorio
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
