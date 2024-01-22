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
        Schema::create('permiso_viaje_participant_external', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_permiso_viaje');
            $table->string('type_doc', 20)->nullable();
            $table->string('num_doc', 20)->nullable();
            $table->string('name',100);
            $table->string('paternal',100)->nullable();
            $table->string('maternal',100)->nullable();
            $table->date('birthday')->nullable();
            $table->string('age',3)->nullable();
            $table->integer('type')->nullable();
            $table->string('sex',1)->nullable();
            $table->string('status_civil',20)->nullable();
            $table->string('nationality',20)->nullable();
            $table->string('locality',20)->nullable();
            $table->string('address',200)->nullable();
            $table->boolean('with_signature')->default(0)->nullable();
            $table->string('email',200)->nullable();
            $table->string('num_partida',100)->nullable();
            $table->string('sede_registral',100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso_viaje_participant_external');
    }
};
