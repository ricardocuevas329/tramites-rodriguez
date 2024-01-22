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
        Schema::table('clientes_tramites', function (Blueprint $table) {
            $table->string('cod_auth', 20)->nullable();
        });

        Schema::table('clientes_tramites', function (Blueprint $table) {
            $table->index('cod_auth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes_tramites', function (Blueprint $table) {
            $table->dropColumn('cod_auth');
        });
    }
};
