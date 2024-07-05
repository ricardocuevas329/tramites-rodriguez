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
        Schema::table('empresa', function (Blueprint $table) {
            $table->index('s_nombre');
            $table->index('i_nacionalidad');
            $table->index('s_localidad');
            $table->index('s_direccion');
            $table->index('s_referencia');
            $table->index('s_email');
            $table->index('s_web');
            $table->index('s_telefono');
            $table->index('s_celular');
            $table->index('s_oficina');
            $table->index('s_partida');
            $table->index('s_registro');
            $table->index('s_ciiu');
            $table->index('s_anotacion');
            $table->index('s_personal_reg');
            $table->index('s_personal_mod');
            $table->index('d_fecha_reg');
            $table->index('s_objeto_social');
            $table->index('s_tip_doc');
            $table->index('d_fecha_mod');
            $table->index('i_estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresa', function (Blueprint $table) {
            $table->dropIndex('s_nombre');
            $table->dropIndex('i_nacionalidad');
            $table->dropIndex('s_localidad');
            $table->dropIndex('s_direccion');
            $table->dropIndex('s_referencia');
            $table->dropIndex('s_email');
            $table->dropIndex('s_web');
            $table->dropIndex('s_telefono');
            $table->dropIndex('s_celular');
            $table->dropIndex('s_oficina');
            $table->dropIndex('s_partida');
            $table->dropIndex('s_registro');
            $table->dropIndex('s_ciiu');
            $table->dropIndex('s_anotacion');
            $table->dropIndex('s_personal_reg');
            $table->dropIndex('s_personal_mod');
            $table->dropIndex('d_fecha_reg');
            $table->dropIndex('s_objeto_social');
            $table->dropIndex('s_tip_doc');
            $table->dropIndex('d_fecha_mod');
            $table->dropIndex('i_estado');
        });
    }
};
