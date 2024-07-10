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

        Schema::create('detalle_procurador_documentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_detalle_procurador')->nullable();
            $table->string('s_personal',50)->nullable();
            $table->text('file')->nullable();
            $table->string('name',100);
            $table->string('type',100)->nullable();
            $table->integer('size')->nullable();
            $table->string('tipo_doc',10)->nullable();
            $table->integer('i_estado');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('detalle_procurador_documentos', function (Blueprint $table) {
            $table->index('id_detalle_procurador');
            $table->index('s_personal');
            $table->index('i_estado');
            $table->index('tipo_doc');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_procurador_documentos');
    }
};
