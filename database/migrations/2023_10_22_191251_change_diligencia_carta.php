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
        Schema::table('diligencia_carta', function (Blueprint $table) {

            $table->dropColumn('i_edificio');
            $table->dropColumn('i_casa');
            $table->dropColumn('i_buzon');
            $table->dropColumn('i_bajo_puerta');

            $table->string('inmueble',50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diligencia_carta', function (Blueprint $table) {
            $table->boolean('i_edificio')->default(0)->nullable();
            $table->boolean('i_casa')->default(0)->nullable();
            $table->boolean('i_buzon')->default(0)->nullable();
            $table->boolean('i_bajo_puerta')->default(0)->nullable();

            $table->dropColumn('inmueble');
        });
    }
};
