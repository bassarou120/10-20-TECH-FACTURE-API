<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMomo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_aderant',
        "montant",
        "operateur",
        "Motif",
        "transref",
        "status"
    ];
}
