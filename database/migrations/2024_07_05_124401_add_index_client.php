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
        Schema::table('cliente', function (Blueprint $table) {
            $table->index('s_materno');
            $table->index('s_nombres');
            $table->index('d_fecha_nac');
            $table->index('s_estado_civil');
            $table->index('s_nacionalidad');
            $table->index('s_localidad');
            $table->index('s_direccion');
            $table->index('s_referencia');
            $table->index('s_sexo');
            $table->index('s_correo');
            $table->index('s_profesion');
            $table->index('s_otro_profesion');
            $table->index('s_telefono');
            $table->index('s_celular');
            $table->index('s_cargo');
            $table->index('s_otro_cargo');
            $table->index('i_residencia');
            $table->index('d_fecha_reg');
            $table->index('s_personal_reg');
            $table->index('s_personal_mod');
            $table->index('s_tipoDocu');
            $table->index('d_fecha_mod');
            $table->index('i_estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cliente', function (Blueprint $table) {
            $table->dropIndex('s_materno');
            $table->dropIndex('s_nombres');
            $table->dropIndex('d_fecha_nac');
            $table->dropIndex('s_estado_civil');
            $table->dropIndex('s_nacionalidad');
            $table->dropIndex('s_localidad');
            $table->dropIndex('s_direccion');
            $table->dropIndex('s_referencia');
            $table->dropIndex('s_sexo');
            $table->dropIndex('s_correo');
            $table->dropIndex('s_profesion');
            $table->dropIndex('s_otro_profesion');
            $table->dropIndex('s_telefono');
            $table->dropIndex('s_celular');
            $table->dropIndex('s_cargo');
            $table->dropIndex('s_otro_cargo');
            $table->dropIndex('i_residencia');
            $table->dropIndex('d_fecha_reg');
            $table->dropIndex('s_personal_reg');
            $table->dropIndex('s_personal_mod');
            $table->dropIndex('s_tipoDocu');
            $table->dropIndex('d_fecha_mod');
            $table->dropIndex('i_estado');
        });
    }
};
