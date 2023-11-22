<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adherants', function (Blueprint $table) {
            //
            $table->string('status')->after('email');
            $table->string('password')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adherants', function (Blueprint $table) {
            //
            $table->string('status')->after('email')->nullable(true);
            $table->string('password')->after('email')->nullable(true);
        });
    }
};
