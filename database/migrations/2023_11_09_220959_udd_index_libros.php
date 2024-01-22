<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('libros', function (Blueprint $table) {
            $table->index('s_codigo');
            $table->index('s_cliente');
            $table->index('s_facturar');
            $table->index('s_entregado');
            $table->index('s_representante');
            $table->index('s_personal_entrega');
            $table->index('s_atendido');
            $table->string('d_fecha_cierre', 100)->change();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('libros', function (Blueprint $table) {
            $table->string('d_fecha_cierre', 100)->change();
        });
    }
};
