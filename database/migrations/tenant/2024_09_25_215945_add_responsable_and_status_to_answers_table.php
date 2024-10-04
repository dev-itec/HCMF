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
        Schema::table('answers', function (Blueprint $table) {
            $table->string('responsable')->nullable()->after('personas_involucradas'); // Campo para responsable
            $table->string('status')->default('pendiente')->after('responsable'); // Campo para status, por defecto "pendiente"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('responsable');
            $table->dropColumn('status');
        });
    }
};
