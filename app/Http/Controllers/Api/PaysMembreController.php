<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\PaysMembre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaysMembreController extends Controller
{
    //

    function listPays (){

//        $pays=PaysMembre::all()->sortBy("pays")->values();
        $pays=PaysMembre::orderBy('pays')->get();

        return new PostResource(true, 'List Data Pays', $pays);
    }


    function getPaysByCode(Request $request){

        $pays= DB::table('pays_membres')
            ->where('code', '=', $request->code)
            ->orderBy('id', 'desc')
            ->get()->first();

        return new PostResource(true, 'List Data Pays', $pays);

    }


    function getPaysMembre(){

        $paysMembre = DB::table('pays_membres')
            ->where('status', '=', "oui")
            ->orderBy('id', 'desc')
            ->get();
        return new PostResource(true, 'List Data Pays Membre', $paysMembre);

    }

    function updateStatusPays(Request $request){

        $pays=PaysMembre::find($request->id);

        $pays->update([
          'status'=> $request->status
        ]);

    }
}
