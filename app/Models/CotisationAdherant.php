<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotisationAdherant extends Model
{
    use HasFactory;


    protected $fillable = [
        "montant","motif","telephone","detailpayement","observation",'adherant_id','status'
    ];
}
