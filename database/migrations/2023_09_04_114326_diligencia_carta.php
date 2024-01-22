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
        Schema::create('diligencia_carta', function (Blueprint $table) {
            $table->bigIncrements('i_codigo');
            $table->integer('s_num_carta')->nullable();
            $table->datetime('d_fecha_entrega')->nullable();
            $table->string('s_recibido_por',50)->nullable();
            $table->string('s_recibido_dni',20)->nullable();
            $table->string('s_relacion_destinatario',50)->nullable();
            $table->boolean('i_edificio')->default(0)->nullable();
            $table->boolean('i_casa')->default(0)->nullable();
            $table->boolean('i_buzon')->default(0)->nullable();
            $table->boolean('i_bajo_puerta')->default(0)->nullable();
            $table->string('s_pisos', 50)->nullable();
            $table->string('s_color', 50)->nullable();
            $table->string('s_puertas', 50)->nullable();
            $table->string('s_ventanas', 50)->nullable();
            $table->string('s_proyeccion', 50)->nullable();
            $table->string('s_observacion',250)->nullable();
            $table->string('s_diligenciado', 10)->nullable();
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
        Schema::dropIfExists('diligencia_carta');
    }
};
