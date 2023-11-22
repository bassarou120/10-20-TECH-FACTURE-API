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

        {
//            "email": "yacouboubassarou@gmail.com",
//  "mode": "1",
//  "civilite": "Dr",
//  "type_organisation": "Fournisseurs / Sociétés de maintenance etc.",
//  "nom": "propre",
//  "prenom": "Ville",
//  "nom_organisation": "TopTic-Solution",
//  "pays": "Antarctique",
//  "fonction": "ssada",
//  "telephone": "",
//  "attentes": "sdasdasd"
}
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string("email");
            $table->string("mode");
            $table->string("civilite");
            $table->string("nom");
            $table->string("prenom");
            $table->string("nom_organisation");
            $table->string("pays");
            $table->string("fonction");
            $table->string("telephone");
            $table->string("attentes");
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')
                ->references('id')
                ->on('actualites');

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
        Schema::dropIfExists('reservations');
    }
};
