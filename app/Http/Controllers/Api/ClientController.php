<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Actualite;
use App\Models\Client;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    //

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $client = Client::latest()->paginate(200);

        //return collection of posts as a resource
        return new PostResource(true, 'List des client', $client);
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

            'nom'     => 'required',
            'prenom'   => 'required',
            'adresse'   => 'required',

        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $client = Client::create([
            "nom" => $request->nom,
            "prenom" => $request->prenom,
            "email" => $request->email,
            "telephone" => $request->telephone,
            "adresse" => $request->adresse

        ]);

        //return response
        return new PostResource(true, 'clent bien enregistré  !', $client);
    }

    /**
     * show
     *
     * @param  mixed $client
     * @return void
     */
    public function show(Client $client)
    {
        //return single post as a resource
        return new PostResource(true, 'Client detail !', $client);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $client
     * @return void
     */
    public function update(Request $request, Client $client)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nom'     => 'required',
            'prenom'   => 'required',
            'adresse'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $client->update([
            "nom" => $request->nom,
            "prenom" => $request->prenom,
            "email" => $request->email,
            "telephone" => $request->telephone,
            "adresse" => $request->adresse
        ]);


        //return response
        return new PostResource(true, 'Client modifié avec success', $client);
    }

    /**
     * destroy
     *
     * @param  mixed $client
     * @return void
     */
    public function destroy(Client $client)
    {

        //delete post
        $client->delete();

        //return response
        return new PostResource(true, 'client', null);
    }
}
