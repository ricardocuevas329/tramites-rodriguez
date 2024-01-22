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
            $table->string('cod_personal')->nullable();
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tramite_kardex_externo_document', function (Blueprint $table) {
            $table->dropColumn('cod_personal');
        });
    }
};
