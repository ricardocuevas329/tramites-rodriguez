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
        Schema::create('detalle_procurador', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('s_presencia', 50)->nullable();
            $table->string('s_procurador',50)->nullable();
            $table->dateTime('s_date_inicio')->nullable();
            $table->dateTime('s_date_fin')->nullable();
            $table->string('s_anotacion',100)->nullable();
            $table->integer('i_estado');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('detalle_procurador', function (Blueprint $table) {
            $table->index('s_presencia');
            $table->index('s_procurador');
            $table->index('s_date_inicio');
            $table->index('s_date_fin');
            $table->index('i_estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_procurador');
    }
};
