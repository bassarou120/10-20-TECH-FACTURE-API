<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\DetailFacture;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailFactureController extends Controller
{
    //

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [

            "facture_id"   => 'required',
            "produit_id"  => 'required',
            "qte"  => 'required',


        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $detail = DetailFacture::create([

            "facture_id"=> $request->facture_id,
            "produit_id"=> $request->produit_id,
            "qte"=> $request->qte,

        ]);

        //return response
        return new PostResource(true, 'detail facture bien enregistré  !', $detail);
    }

}
