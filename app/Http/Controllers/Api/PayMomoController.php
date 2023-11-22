<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\PayMomo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Validator;
use Psy\Util\Str;


class PayMomoController extends Controller
{
    //

    public function addPayMomo(Request $request){

        $validator = Validator::make($request->all(), [
            'operateurMomo'     => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $transref= \Illuminate\Support\Str::random(8);


        $payMomo=PayMomo::create([
            'id_aderant'=>strval($request->id_aderant),
            "montant"=>$request->montantAdhesion,
            "operateur"=>$request->operateurMomo,
            "Motif"=>$request->typePayement,
            "transref"=>$transref,
            "status"=>"no"
        ]);

        $payMomoNew=PayMomo::find($payMomo->id);

        switch ($request->operateurMomo){
            case "MTN BENIN":
            $response = Http::withBasicAuth(env("MTN_USER"), env('MTN_USER_PASS'))->post(
                    env('MTN_URL_REQUEST_PAYMENT'), [
                    "msisdn"=>"229".$request->telephoneMomo,
                    "amount"=> $request->montantAdhesion,
                    "firstname"=>$request->nomMomo,
                    "lastname"=>$request->prenomMomo,
                    "transref" =>$transref,
                    "clientid"=> env('MTN_ID_CLIENT')
                ]);


//                {"responsecode":"01","responsemsg":"PENDING","transref":"s59OACo6","serviceref":"5878021560","comment":null}.

                error_log( $response->object()->responsecode );

                switch ($response->object()->responsecode){
                    case "01":
                        sleep(10);

                        $status=$this->gettransactionstatus($transref,env('MTN_ID_CLIENT'));
                        if ( $status=="00"){
                            $payMomoNew->update(['status'=>"SUCCESSFUL"]);
                            return new PostResource(true, 'SUCCESSFUL',$response->body());
                        }elseif ($status=="-1"){
                            $payMomoNew->update(['status'=>"FAILED"]);
                            return new PostResource(false, 'FAILED',$response->body());
                        }
                        sleep(10);
                        $status=$this->gettransactionstatus($transref,env('MTN_ID_CLIENT'));
                        if (  $status=="00"){
                            $payMomoNew->update(['status'=>"SUCCESSFUL"]);
                            return new PostResource(true, 'SUCCESSFUL',$response->body());
                        }else{
                            $payMomoNew->update(['status'=>"FAILED"]);
                            return new PostResource(false, 'FAILED',$response->body());
                        }

                    case '529':
                        $payMomoNew->update(['status'=>"TARGET_AUTHORIZATION_ERROR"]);
                        return new PostResource(false, 'TARGET_AUTHORIZATION_ERROR',$response->body());


                        break;
                }

                $payMomoNew->update(['status'=>"FAILED"]);
                return new PostResource(false, 'FAILED',$response->body());

                break;

            case "MOOV BENIN":

                $response = Http::withBasicAuth(env("MOOV_USER"), env('MOOV_USER_PASS'))->post(
                    env('MOOV_URL_REQUEST_PAYMENT'), [
                    "msisdn"=>"229".$request->telephoneMomo,
                    "amount"=> $request->montantAdhesion,
                    "firstname"=>$request->nomMomo,
                    "lastname"=>$request->prenomMomo,
                    "transref" =>$transref,
                    "clientid"=> env('MOOV_ID_CLIENT')
                ]);

                switch ($response->object()->responsecode){
                    case "0":
                        $payMomoNew->update(['status'=>"SUCCESSFUL"]);
                        return new PostResource(true, 'SUCCESSFUL',$response->body());
                        break;
                        $payMomoNew->update(['status'=>"FAILED"]);
                        return new PostResource(false, 'FAILED',$response->body());


                        break;
                }
                $payMomoNew->update(['status'=>"FAILED"]);
                return new PostResource(false, 'FAILED',$response->body());


                break;
        }





    }



    private  function gettransactionstatus( $transref, $clientid){

        $response1 = Http::withBasicAuth("QSUSR37", "MztFY5mZmKr67KsN1qD8")->post(
            env('TRANSACTION_STATE'), [

            "transref" =>$transref,
            "clientid"=> $clientid
        ]);
        error_log( $response1->object()->responsecode );

        return   $response1->object()->responsecode  ;


    }



}
