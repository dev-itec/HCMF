<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerStatusHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('answer_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_id')->constrained('answers')->onDelete('cascade'); // Relación con la tabla answers
            $table->string('old_status')->nullable(); // Estado anterior
            $table->string('new_status'); // Nuevo estado
            $table->foreignId('changed_by')->nullable()->constrained('users'); // Usuario que realizó el cambio (opcional)
            $table->timestamps(); // Timestamps para saber cuándo ocurrió el cambio
        });
    }

    public function down()
    {
        Schema::dropIfExists('answer_status_histories');
    }
};
