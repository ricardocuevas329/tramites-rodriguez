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
            $table->boolean('estado_clic')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tramite_kardex_externo_document', function (Blueprint $table) {
            $table->dropColumn('estado_clic');
        });
    }
};
