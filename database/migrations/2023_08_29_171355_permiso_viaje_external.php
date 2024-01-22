<?php

use  Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permiso_viaje_external', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('id_user_register')->nullable();
            $table->string('travel',100);
            $table->string('date_ret',50)->nullable();
            $table->string('date_sal',50)->nullable();
            $table->integer('return')->nullable();
            $table->integer('type')->nullable();
            $table->integer('format')->nullable();
            $table->string('line', 300)->nullable();
            $table->text('obervation')->nullable();
            $table->text('route',300);
            $table->integer('transport');
            $table->boolean('read')->default(0)->nullable();
            $table->string('id_user_read',100)->nullable();
            $table->dateTime('date_read')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso_viaje_external');
    }
};
