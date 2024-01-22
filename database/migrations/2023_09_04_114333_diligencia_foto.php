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
        Schema::create('diligencia_foto', function (Blueprint $table) {
            $table->bigIncrements('i_codigo');
            $table->integer('i_diligencia_carta')->nullable();
            $table->text('s_foto');
            $table->string('s_name',100);
            $table->string('s_type',100)->nullable();
            $table->integer('i_size')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diligencia_foto');
    }
};
