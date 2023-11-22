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
            $table->string('forme_juridique')->nullable()->change();
            $table->string('pays')->nullable()->change();;
            $table->string('ville')->nullable()->change();;
            $table->string('code_postale')->nullable()->change();;
            $table->string('site_web')->nullable()->change();;
            $table->string('adresse')->nullable()->change();;

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
            $table->string('forme_juridique')->nullable()->change();
            $table->string('pays')->nullable()->change();;
            $table->string('ville')->nullable()->change();;
            $table->string('code_postale')->nullable()->change();;
            $table->string('site_web')->nullable()->change();;
            $table->string('adresse')->nullable()->change();;

        });
    }
};
