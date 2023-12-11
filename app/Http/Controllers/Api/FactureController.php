<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Client;
use App\Models\DetailFacture;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FactureController extends Controller
{




   public function getStatistque(){

        $data['nbr_client'] = DB::table('clients')->count();
        $data['nbr_facture'] = DB::table('factures')->count();
        $data['nbr_produit'] = DB::table('produits')->count();
       $data['top10_facture'] =   DB::table('factures')
           ->join('clients','factures.client_id' , '=', 'clients.id')
           ->select('clients.nom','clients.telephone','clients.prenom','factures.*')
           ->orderBy('factures.id',"desc")

    ->paginate(10);
       return new PostResource(true, 'param par key', $data);
    }


        /**
     * index
     *
     * @return void
     */
    public function index()
    {

//        $facture =Facture::latest()->paginate(10);

//        $facture=   DB::table('factures')
//            ->leftJoin('clients','factures.client_id' , '=', 'clients.id')
//            ->get();
//
        $facture=   DB::table('factures')
            ->join('clients','factures.client_id' , '=', 'clients.id')
            ->select('clients.nom','clients.telephone','clients.prenom','factures.*')
            ->get();
//            ->paginate(30);
        //return collection of posts as a resource
        return new PostResource(true, 'List des facture', $facture);
    }


    public function addAllDetailFacture(Request $request){


      $d= $request->all()  ;

      foreach ($d as $value ){

          error_log($value['produit']['designation']);
          error_log($value['produit']['prix']);
          error_log($value['qte']);

          DetailFacture::create([

              "facture_id"=> $request->id,
              "produit_id"=> $value['produit']['id'],
              "prix"=> $value['produit']['prix'],
              "qte"=> $value['qte'],

          ]);



//        var_dump($value['produit']['designation'] );
//        break;
      }
//        var_dump($request->all());


//        error_log($request->all());
   return new PostResource(true, 'facture bien enregistré  !',   $request->id);

    }


    public function getFactureEtDetailById(Request $request){
        $facture=   DB::table('factures')
            ->join('clients','factures.client_id' , '=', 'clients.id')
            ->where("factures.id","=",$request->id)
            ->select('clients.*' ,'factures.*')
            ->get();


        $detailFacture=   DB::table('detail_factures')
            ->join('produits','detail_factures.produit_id' , '=', 'produits.id')
            ->where("detail_factures.facture_id","=",$request->id)
            ->select('produits.designation' ,'detail_factures.*')
            ->get();


        $data['facture']=$facture;
        $data['detailFacture']=$detailFacture;



        return new PostResource(true, 'Client detail !', $data);

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
            'client_id'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $facture = Facture::create([
            "date" => $request->date,
            "montant" => $request->montant,
            "client_id" => $request->client_id,

        ]);

        //return response
        return new PostResource(true, 'facture bien enregistré  !', $facture);
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
