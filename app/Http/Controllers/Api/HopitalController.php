<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Hopital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HopitalController extends Controller
{
    //


    function addhopital(Request $request){

        $validator = Validator::make($request->all(), [
            'libele'=> 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $hoptal=Hopital::create([
            'libele'=>$request->libele,
        'contact'=>$request->contact,
        'adress'=>$request->adress,
        'pays_id'=>$request->pays_id
        ]);

        //return response
        return new PostResource(true, 'hopital ajouté  !', $hoptal);



    }
    function gethoptalByPays(Request $request){


        $hopital = DB::table('hopitals')
            ->where('pays_id', '=', $request->id)

            ->orderBy('id', 'desc')
            ->get();

        return new PostResource(true, 'hopitaux par pays', $hopital);

    }




}
