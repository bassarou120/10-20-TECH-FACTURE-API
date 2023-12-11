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
        Schema::create('detail_factures', function (Blueprint $table) {
            $table->id();

            $table->integer('qte')->nullable(true);
            $table->integer('prix')->nullable(true);

            $table->unsignedBigInteger('facture_id');
            $table->foreign('facture_id')
                ->references('id')
                ->on('factures');

            $table->unsignedBigInteger('produit_id');
            $table->foreign('produit_id')
                ->references('id')
                ->on('produits');
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
        Schema::dropIfExists('detail_factures');
    }
};
