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
        Schema::table('presencias', function (Blueprint $table) {
            $table->index('s_contacto');
            $table->index('s_referente');
            $table->index('s_facturado');
            $table->index('d_fecha_registro');
            $table->index('s_hora_registro');
            $table->index('s_atendido');
            $table->index('i_tipopago');
            $table->index('i_estado');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presencias', function (Blueprint $table) {
            $table->dropIndex('s_contacto');
            $table->dropIndex('s_referente');
            $table->dropIndex('s_facturado');
            $table->dropIndex('d_fecha_registro');
            $table->dropIndex('s_hora_registro');
            $table->dropIndex('s_atendido');
            $table->dropIndex('i_tipopago');
            $table->dropIndex('i_estado');
        });
    }
};
