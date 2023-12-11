<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $produit = Produit::latest()->paginate(200);

        //return collection of posts as a resource
        return new PostResource(true, 'List des Produit', $produit);
    }


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

          "designation"   => 'required',
           "prix"  => 'required',


        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $produit = Produit::create([
            "designation"=> $request->designation,
            "prix"=> $request->prix,
            "observation"=> $request->observation

        ]);

        //return response
        return new PostResource(true, 'produit bien enregistré  !', $produit);
    }

    /**
     * show
     *
     * @param  mixed $client
     * @return void
     */
    public function show(Produit $produit)
    {
        //return single post as a resource
        return new PostResource(true, 'produit detail !', $produit);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $client
     * @return void
     */
    public function update(Request $request, Produit $produit)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            "designation"   => 'required',
            "prix"  => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produit->update([
            "designation"=> $request->designation,
            "prix"=> $request->prix,
            "observation"=> $request->observation
        ]);


        //return response
        return new PostResource(true, 'produit modifié avec success', $produit);
    }

    /**
     * destroy
     *
     * @param  mixed $client
     * @return void
     */
    public function destroy(Produit $produit)
    {
        //delete post
        $produit->delete();
        //return response
        return new PostResource(true, 'produit', null);
    }
}
