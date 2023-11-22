<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Mail\SampleMail;
use App\Models\Actualite;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
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
        $reservation= Reservation::latest()->paginate(50);



        //return collection of posts as a resource
        return new PostResource(true, 'List Data reservation', $reservation);
    }


    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
//            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "email" => 'required',
            "mode" => 'required',
            "civilite" => 'required',
            "nom" => 'required',
            "prenom" => 'required'

        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $reservation = Reservation::create([
            "email"=> $request->email,
            "mode"=> $request->mode,
            "civilite"=> $request->civilite,
            "nom"=> $request->nom,
            "prenom"=> $request->prenom,
            "nom_organisation"=> $request->nom_organisation,
            "pays"=> $request->pays,
            "fonction"=> $request->fonction,
            "telephone"=> $request->telephone,
            "attentes"=> $request->attentes,
            "event_id"=> intval($request->event_id)
        ]);

        $envet=Actualite::find(intval($request->event_id));

        $content =[];
        if ($envet->prix=="0" ||$envet->prix==null){
            $content = [
                'subject' => 'Reservation pour un evernement du RESHAOC',
                'body' => $request->civilite." ".  $request->nom." <br>
Votre resevrvation pour l'evernement <b>".$envet->title . "</b> a été  enregistrée avec succès, l'equipe du RESHAOC  vous contactera et vous assistera pour etape suivantes. <br>

 Pour toute information complementaire veuillez nous catacter via info@reshaoc.org <br>»
"
            ];
        }else{

            $content = [
                'subject' => 'Reservation pour un evernement du RESHAOC',
                'body' => $request->civilite." ".  $request->nom." <br>
Votre resevrvation pour l'evernement <b>".$envet->title . "</b> a été  enregistrée avec succès, l'equipe du RESHAOC  vous contactera et vous assistera pour etape suivantes. <br>
Cliquer sur le button ci-dessous pour proceder au paiment des frais de participations <br>
<button href='resahoc.org' style='color: white;background-color: #2467af'> Payer</button><br>


 Pour toute information complementaire veuillez nous catacter via info@reshaoc.org <br>»
"
            ];
        }


        Mail::to($request->email)->send(new SampleMail($content));




        return new PostResource(true, 'Data reservation  !', $reservation);

    }


    public function getReservationByEvent(Request $request){


        $reservation= DB::table('reservations')
                ->where('event_id', '=', $request->id)

                ->orderBy('id', 'desc')
                ->get();

        return new PostResource(true, 'Data reservation  !', $reservation);



    }
}
