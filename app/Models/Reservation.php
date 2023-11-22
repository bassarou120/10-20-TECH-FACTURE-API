<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
     "email",
 "mode",
 "civilite",
 "nom",
 "prenom",
 "nom_organisation",
 "pays",
 "fonction",
 "telephone",
 "attentes", "event_id"
    ];

}
