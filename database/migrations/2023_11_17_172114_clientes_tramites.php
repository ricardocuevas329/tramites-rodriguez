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
        Schema::create('clientes_tramites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_documento', 5);
            $table->string('documento', 20);
            $table->string('nombres');
            $table->string('paterno');
            $table->string('materno')->nullable();
            $table->string('kardex')->nullable();
            $table->string('cod_personal',50);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('clientes_tramites', function (Blueprint $table) {
            $table->index('tipo_documento');
            $table->index('cod_personal');
            $table->index('kardex');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes_tramites');
    }
};
