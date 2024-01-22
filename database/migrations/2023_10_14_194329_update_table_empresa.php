<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('empresa', function (Blueprint $table) {
            $table->string('s_pass', 200)->change();
        });
    }

    public function down()
    {
        Schema::table('empresa', function (Blueprint $table) {
            $table->string('s_pass', 30)->change();
        });
    }
};
