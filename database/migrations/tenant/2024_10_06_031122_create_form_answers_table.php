<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('form_answers')) {
            Schema::create('form_answers', function (Blueprint $table) {
                $table->id(); 
                $table->text('ans_text');
                $table->foreignId('question_id')->constrained('questions');
                $table->foreignId('denuncia_id')->constrained('answers');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('form_answers');
    }
};
