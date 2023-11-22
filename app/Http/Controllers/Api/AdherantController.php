<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PostResource;

use App\Mail\SampleMail;
use App\Models\Actualite;
use App\Models\Adherant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\Input;

class AdherantController extends Controller
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
        $adherant = Adherant::latest()->paginate(100);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $adherant);
    }

    /**
     *
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request)
    {
        $adherant=DB::table('adherants')
            ->where('email', '=', $request->adherantId)
            ->where('password','=',$request->password)
            ->orderBy('id', 'desc')
            ->get()->last() ;

        if ( $adherant!=null){

            $adherant->password="zero";
            return new PostResource(true, 'List Data Posts', $adherant);

        }else {
            return new PostResource(false, 'List Data Posts', "");
        }


    }
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {


//        error_log(DB::table('actualites')->where('email','=',$request->email)->get()."ici");
//        error_log(sizeof(DB::table('actualites')->where('email','=',$request->email)->get()));

        //define validation rules
        $validator = Validator::make($request->all(), [
//            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'raison_sociale'     => 'required',
            'email'     => 'required',
            'telephone'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (  sizeof(DB::table('adherants')->where('email','=',$request->email)->get()) > 0  ){

            return   new PostResource(false, "Cette adresse e-mail est déjà utilisée ", "");
//            return response()->json("le numero de detelephone  existe deja", 422);
        }

        if(

             sizeof(DB::table('adherants')->where('telephone','=',$request->telephone)->get()) > 0

        ){
//            return response()->json("Cette numéro de téléphone est déjà utilisée ", 422);
            return   new PostResource(false, "Cette numéro de téléphone est déjà utilisée ", "");



        }else{


//            $hashed_random_password = Hash::make(str_random(8));
//            $hashed_random_password = Hash::
            $password = Str::random(8);

            error_log($password);

            $adherant = Adherant::create([
                'raison_sociale'=>$request->raison_sociale,
                'forme_juridique'=>$request->forme_juridique,
                'email'=>$request->email,
                'telephone'=>$request->telephone,
                'pays'=>$request->pays,
                'ville'=>$request->ville,
                'code_postale'=>$request->code_postale,
                'site_web'=>$request->site_web,
                'adresse'=>$request->adresse,
                'categorie'=>$request->categorie,
                'prenom_dirigeant'=>$request->prenom_dirigeant,
                'nom_dirigeant'=>$request->nom_dirigeant,
                'email_dirigeant'=>$request->email_dirigeant,
                'password'=> $password

            ]);



            $content = [
                'subject' => 'Vos identifiants pour accéder à la Plateforme Professionnelle ',
                'body' => "Monsieur ".  $request->raison_sociale." <br>
votre enregistrement sur la plateforme professionnelle du RESHAOC a été effectué avec succès.
Vous pouvez désormais accéder à votre compte en utilisant les identifiants ci-après <br>
Idenfiant :<b>".$request->email."</b><br> Votre mot de passe est :<b>".$password."</b> <br>
toutefois vous avez la possibilité de le changer dans votre espace personnel dans la rubrique « profile »
<br> Pour activer votre compte veuillez procéder au paiement.
"
            ];

            Mail::to($request->email)->send(new SampleMail($content));




        }







        //return response
        return new PostResource(true, 'Adherant creer avec succes   !', $adherant);
    }

}
