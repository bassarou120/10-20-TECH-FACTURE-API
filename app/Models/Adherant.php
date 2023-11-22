<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adherant extends Model
{
    use HasFactory;


    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['raison_sociale','forme_juridique','email','telephone',
'pays' ,'ville' ,'code_postale' ,'site_web','adresse', 'categorie' , 'prenom_dirigeant', 'nom_dirigeant'
,'elephone_dirigeant'
,'email_dirigeant',"password","status"];
}
