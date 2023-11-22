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
        Schema::create('reshaocs', function (Blueprint $table) {
            $table->id();
            $table->longText('presentation');
            $table->longText('mission');
            $table->longText('objectif');
            $table->longText('organisation');
            $table->longText('plan');
            $table->longText('document');


            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reshaocs');
    }
};
