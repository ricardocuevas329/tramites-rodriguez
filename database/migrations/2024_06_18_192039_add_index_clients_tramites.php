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
            $table->index('documento');
            $table->index('nombres');
            $table->index('paterno');
            $table->index('materno');
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes_tramites', function (Blueprint $table) {
            $table->dropIndex('documento');
            $table->dropIndex('nombres');
            $table->dropIndex('paterno');
            $table->dropIndex('materno');
            $table->dropIndex('created_at');
            $table->dropIndex('updated_at');
            $table->dropIndex('deleted_at');
        });
    }
};
