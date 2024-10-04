<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            // Cambia la columna existente a json si no lo es o realiza otros cambios
            $table->json('evidencia')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            // Define cómo revertir el cambio si es necesario
            $table->text('evidencia')->nullable()->change(); // Cambia a su formato anterior si no era json
        });
    }
};
