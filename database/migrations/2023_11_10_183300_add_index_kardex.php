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
        Schema::table('kardex', function (Blueprint $table) {
            $table->index('s_actnot');
            $table->index('s_compareciente');
            $table->index('s_referente');
            $table->index('s_facturar');
            $table->index('s_atendido');
            $table->index('s_responsable');
            $table->index('s_digitado');
            $table->index('d_fecha_digitado');
            $table->index('s_impreso');
            $table->index('s_confrontador');
            $table->index('s_personal_testimonio');
            $table->index('s_abogado');
            $table->index('s_personal_abogado');
            $table->index('d_fecha_abogado');
            $table->index('s_anno');
            $table->index('i_serini');
            $table->index('s_numreg');
            $table->index('i_numeroOperacion');
            $table->index('s_obstitulo');
            $table->index('s_num_solicitud');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
