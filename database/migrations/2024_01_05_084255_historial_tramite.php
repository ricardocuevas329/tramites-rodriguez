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
        Schema::create('historial_tramite', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('s_tramite')->nullable();
            $table->integer('i_tipo')->nullable();
            $table->string('s_personal')->nullable();
            $table->text('s_observacion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('historial_tramite', function (Blueprint $table) {
            $table->index('s_tramite');
            $table->index('s_personal');
            $table->index('i_tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_tramite');
    }
};
