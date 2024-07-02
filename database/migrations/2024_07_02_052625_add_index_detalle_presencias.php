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

        Schema::table('detalle_presencias', function (Blueprint $table) {
            $table->index('s_referencia');
            $table->index('s_actonotarial');
            $table->index('s_hora_inicio');
            $table->index('s_hora_fin');
            $table->index('d_fechapresen');
            $table->index('s_asitente');
            $table->index('i_cantidad');
            $table->index('de_precio');
            $table->index('i_estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_presencias', function (Blueprint $table) {

            $table->dropIndex('s_referencia');
            $table->dropIndex('s_actonotarial');
            $table->dropIndex('s_hora_inicio');
            $table->dropIndex('s_hora_fin');
            $table->dropIndex('d_fechapresen');
            $table->dropIndex('s_asitente');
            $table->dropIndex('i_cantidad');
            $table->dropIndex('de_precio');
            $table->dropIndex('i_estado');


        });
    }
};
