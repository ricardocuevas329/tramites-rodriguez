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
        Schema::create('diligencia_programada', function (Blueprint $table) {
            $table->bigIncrements('i_codigo');
            $table->datetime('d_fecha_programacion')->nullable();
            $table->integer('s_num_carta')->nullable();
            $table->string('s_observacion',250)->nullable();
            $table->string('s_motorizado',8)->nullable();
            $table->string('s_personal_reg',8)->nullable();
            $table->tinyInteger('i_estado')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diligencia_programada');
    }
};
