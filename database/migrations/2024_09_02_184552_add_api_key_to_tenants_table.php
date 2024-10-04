<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('api_key')->nullable()->after('password'); // Añade la columna 'api_key' después de la columna 'password'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn('api_key'); // Elimina la columna 'api_key' si la migración se revierte
        });
    }
};
