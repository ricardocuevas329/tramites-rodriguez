<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->index('i_estado');
            $table->index('i_rapidos');
            $table->index('s_nombre');
            $table->index('s_generico');
            $table->index('i_formato');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->dropIndex('i_estado');
            $table->dropIndex('i_rapidos');
            $table->dropIndex('s_nombre');
            $table->dropIndex('s_generico');
            $table->dropIndex('i_formato');

        });
    }
};
