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
        Schema::create('permiso_viaje_document', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_permiso_viaje');
            $table->bigInteger('id_participant')->nullable();
            $table->text('file');
            $table->string('name',100);
            $table->string('type',100)->nullable();
            $table->integer('size')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso_viaje_document');
    }
};
