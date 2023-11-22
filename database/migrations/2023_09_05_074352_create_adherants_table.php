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
//raison_sociale,forme_juridique,email,telephone
//pays ,ville ,code_postale ,site_web
//adresse, categorie , prenom_dirigeant, nom_dirigeant
//telephone_dirigeant
//email_dirigeant

    public function up()
    {
        Schema::create('adherants', function (Blueprint $table) {
            $table->id();
            $table->string('raison_sociale');
            $table->string('forme_juridique');
            $table->string('email');
            $table->string('telephone');
            $table->string('pays');
            $table->string('ville');
            $table->string('code_postale');
            $table->string('site_web');
            $table->string('adresse');
            $table->string('categorie');
            $table->string('prenom_dirigeant')->nullable(true);
            $table->string('nom_dirigeant')->nullable(true);
            $table->string('email_dirigeant')->nullable(true);
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
        Schema::dropIfExists('adherants');
    }
};
