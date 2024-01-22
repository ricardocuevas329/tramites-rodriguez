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
        Schema::table('recibopago', function (Blueprint $table) {
            $table->index('s_facturado');
            $table->index('s_Atendido');
            $table->index('s_caja');
            $table->index('s_anulado');
            $table->index('s_autorizado');
            $table->index('s_tipoDocumento');
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
