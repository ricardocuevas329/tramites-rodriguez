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
        Schema::create('libro_document', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_libro');
            $table->text('file');
            $table->string('name',100);
            $table->string('type',100)->nullable();
            $table->integer('size')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('libro_document', function (Blueprint $table) {
            $table->index('id_libro');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro_document');
    }
};
