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
        Schema::table('tramite_kardex_externo_document', function (Blueprint $table) {
            $table->index('tipo_archivo');
            $table->index('cod_personal');
            $table->index('estado_clic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tramite_kardex_externo_document', function (Blueprint $table) {
            $table->dropIndex('tipo_archivo');
            $table->dropIndex('cod_personal');
            $table->dropIndex('estado_clic');
        });
    }
};
