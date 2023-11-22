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
        Schema::create('cotisation_adherants', function (Blueprint $table) {
            $table->id();
            $table->string("montant");
            $table->string("motif")->nullable(true);
            $table->string("telephone")->nullable(true);
            $table->string("detailpayement")->nullable(true);
            $table->string("observation")->nullable(true);
            $table->string("status")->nullable(true);

            $table->unsignedBigInteger('adherant_id');
            $table->foreign('adherant_id')
                ->references('id')
                ->on('adherants');
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
        Schema::dropIfExists('cotisation_adherants');
    }
};
