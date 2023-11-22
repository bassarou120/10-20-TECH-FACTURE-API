<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\CotisationAdherant;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CotisationAdherantController extends Controller
{
    //
    public function index()
    {
        //get posts
        $cotisations= CotisationAdherant::latest()->paginate(50);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data cotisation', $cotisations);
    }
    public function listCotisationByAdherant()
    {
        //get posts
//        $cotisations= DB::table('cotisation_adherants')
//            ->leftJoin('adherants', 'cotisation_adherants.adherant_id', '=', 'adherants.id')
//            ->get();
  $cotisations= DB::table('adherants')
            ->rightJoin('cotisation_adherants', 'cotisation_adherants.adherant_id', '=', 'adherants.id')
            ->get();



        //return collection of posts as a resource
        return new PostResource(true, 'List Data cotisation', $cotisations);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
//            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "montant" => 'required',
            "adherant_id" => 'required',

        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $cotisation = CotisationAdherant::create([
            "montant"=>$request->montant,
            "motif"=>$request->motif,
            "telephone"=>$request->telephone,
            "detailpayement"=>$request->detailpayement,
            "observation"=>$request->observation,
            'adherant_id'=>intval($request->adherant_id),
            'status'=>$request->status

        ]);

        return new PostResource(true, 'Data cotisation  !', $cotisation);

    }

    public function  getCotisationByAdherant(Request $request){


        $cotisation= DB::table('cotisation_adherants')
            ->where('adherant_id', '=', $request->id)

            ->orderBy('id', 'desc')
            ->get();

        return new PostResource(true, 'Data cotisation  !', $cotisation);



    }


}
