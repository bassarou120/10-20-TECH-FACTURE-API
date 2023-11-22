<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaysMembre extends Model
{
    use HasFactory;

    protected $fillable = ['pays' ,
'code' ,
'status' ];
}
