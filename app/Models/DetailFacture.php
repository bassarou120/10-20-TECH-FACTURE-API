<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailFacture extends Model
{
    use HasFactory;
    protected $fillable = ["facture_id","produit_id","qte","prix","produit_id"];
}
