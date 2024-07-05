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
        Schema::table('personal', function (Blueprint $table) {
            $table->index('s_codigo');
            $table->index('s_tipoDocu');
            $table->index('s_numero');
            $table->index('s_estadoCivil');
            $table->index('d_fechaNacimiento');
            $table->index('s_sexo');
            $table->index('s_nacionalidad');
            $table->index('s_distrito');
            $table->index('s_user');
            $table->index('d_fecha_reg');
            $table->index('s_personal_reg');
            $table->index('s_paterno');
            $table->index('s_materno');
            $table->index('s_nombres');
            $table->index('s_nombre_seg');
            $table->index('i_estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal', function (Blueprint $table) {
            $table->dropIndex('s_codigo');
            $table->dropIndex('s_tipoDocu');
            $table->dropIndex('s_numero');
            $table->dropIndex('s_estadoCivil');
            $table->dropIndex('d_fechaNacimiento');
            $table->dropIndex('s_sexo');
            $table->dropIndex('s_nacionalidad');
            $table->dropIndex('s_distrito');
            $table->dropIndex('s_user');
            $table->dropIndex('d_fecha_reg');
            $table->dropIndex('s_personal_reg');
            $table->dropIndex('s_paterno');
            $table->dropIndex('s_materno');
            $table->dropIndex('s_nombres');
            $table->dropIndex('s_nombre_seg');
            $table->dropIndex('i_estado');
        });
    }
};
