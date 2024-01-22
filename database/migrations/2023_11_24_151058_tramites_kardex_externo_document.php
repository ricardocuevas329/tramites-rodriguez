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
        Schema::create('tramite_kardex_externo_document', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_kardex')->nullable();
            $table->text('file');
            $table->string('tipo_archivo',100);
            $table->string('name',100);
            $table->string('type',100)->nullable();
            $table->integer('size')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('tramite_kardex_externo_document', function (Blueprint $table) {
            $table->index('id_kardex');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
