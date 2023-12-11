<?php

namespace App\Http\Controllers\Api;


use App\Models\Actualite;
use App\Models\Reshaoc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ActualiteController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $actulalite = Actualite::latest()->paginate(20);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $actulalite);
    }


    public function lastActualiate(){

//        $lastrecord= Actualite::latest()->first();

        $actulalite = DB::table('actualites')
            ->where('type', '=', "ACTIVITE-PHARE")
            ->orderBy('id', 'desc')
            ->get()->first();
        return new PostResource(true, 'Laste record of reshaoc', $actulalite);

    }

      public function getListeEvent(){

    //        $lastrecord= Actualite::latest()->first();

            $actulalite = DB::table('actualites')
                ->where('type', '=', "JOURNEE-HOSPITALIERE")
                ->orWhere('type', '=', "JOURNEE-COOPERATION")
                ->orWhere('type', '=', "AUTRE-EVERNEMENT")
                ->orderBy('id', 'desc')
                ->get() ;
            return new PostResource(true, 'Laste record of reshaoc', $actulalite);

        }
     public function getActuVedetteByType(Request $request){

    //        $lastrecord= Actualite::latest()->first();

            $actulalite = DB::table('actualites')
                ->where('type', '=', $request->type)
                ->where('isvedette','=',true)
                ->orderBy('id', 'desc')
                ->get()->first() ;


            return new PostResource(true, 'Laste record getActuVedetteByType',$actulalite);

        }

    public function getActuVedetteByType2(Request $request){

        //        $lastrecord= Actualite::latest()->first();

        $actulalite = DB::table('actualites')
            ->where('type', '=', $request->type)
            ->where('isvedette','=',true)
            ->orderBy('id', 'desc')
            ->get()->last() ;


        return new PostResource(true, 'Laste record getActuVedetteByType',$actulalite);

    }



    /**
     * getByType
     *
     * @return void
     */
    public function getByType(Request $request)
    {
        $actulalite = DB::table('actualites')
            ->where('type', '=', $request->type)
            ->orderBy('id', 'desc')
            ->get();

//        $actulalite = Actualite::f;

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $actulalite);
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
//            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'type'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $imgName="default.jpg";
        $fileName="file.pdf";



        //check if image is not empty
        if ($request->hasFile('image')) {
            //upload image
            $image = $request->file('image');
            $image->storeAs('public/actualite', $image->hashName());

            $imgName= $image->hashName();

        }

        //check if file is not empty
        if ($request->hasFile('fichier')) {
            //upload image
            $fichier = $request->file('fichier');
            $fichier->storeAs('public/actualite', $fichier->hashName());

            $fileName= $fichier->hashName();

        }



        //create post
        $actulalite = Actualite::create([
            'image'     =>$imgName,
            'title'     => $request->title,
            'type'     => $request->type,
            'content'   => $request->content,
            'fichier'   => $fileName,
            'date'=>$request->date ? $request->date: null,
            'date_fin'=>$request->date_fin ? $request->date_fin: null,
            'lieu'=>$request->lieu,
            'prix'=>$request->prix,
            'payant'=>$request->prix=="0"||$request->prix==null ?false:true ,
            'id_actualite'=>$request->id_actualite,
            'description'=>$request->description

        ]);



        //return response
        return new PostResource(true, 'Data Post  !', $actulalite);
    }

    /**
     * show
     *
     * @param  mixed $actulalite
     * @return void
     */
    public function show(Actualite $actulalite,$id)
    {
        $act=Actualite::find($id);
        //return single post as a resource
        return new PostResource(true, "voici l'actu que tu demande", $act);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $actulalite
     * @return void
     */
    public function update(Request $request,$id)
    {

    $actulalite=Actualite::find($id);

        //define validation rules
        $validator = Validator::make($request->all(), [
//            'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'type'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }



        $imgName="default.jpg";
        $fileName="file.pdf";


        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/actualite', $image->hashName());
            $imgName=$image->hashName();

            try {

                //delete old image
                Storage::delete('public/actualite/'.$actulalite->image);

            } catch(\Exception $exception){

            }



        } else{
            $imgName=$actulalite->image;
        }

        //check if file is not empty
        if ($request->hasFile('fichier')) {

            //upload image
            $fichier = $request->file('fichier');
            $fichier->storeAs('public/actualite', $fichier->hashName());
            $fileName=$fichier->hashName();

            try {

                //delete old image
                Storage::delete('public/actualite/'.$actulalite->fichier);


            } catch(\Exception $exception){

            }


        }else{
            $fileName= $actulalite->fichier;

        }


        $request->date_fin !=null ? error_log($request->date_fin):error_log("nunn")  ;

        //update post with new image
        $actulalite->update([
            'image'     => $imgName,
            'fichier'     => $fileName,
            'title'     => $request->title,
            'type'     => $request->type,
            'content'   => $request->content,
            'description'   => $request->description,
            'lieu'   => $request->lieu !=null ? $request->lieu:$actulalite->lieu,
            'date'   => $request->date !=null  ? $request->date :$actulalite->date,
            'date_fin'   => $request->date_fin !=null ? $request->date_fin:$actulalite->date_fin,
//             'date_fin' =>$request->date_fin ? $request->date_fin: null,
            'prix'=>$request->prix,
            'payant'=>$request->prix=="0"||$request->prix==null ?false:true ,
        ]);




        /*
        //check if image is not empty
        if ($request->hasFile('image')) {




            //update post with new image
            $actulalite->update([
                'image'     => $imgName,
                'title'     => $request->title,
                'type'     => $request->type,
                'content'   => $request->content,
                'description'   => $request->description,
                'lieu'   => $request->lieu,
                'date'   => $request->description,
                'date_fin'   => $request->date_fin,
            ]);


        } else {

            //update post without image
            $actulalite->update([
                'title'     => $request->title,
                'content'   => $request->content,
                'type'   => $request->type,
                'description'   => $request->description,
                'lieu'   => $request->lieu,
                'date'   => $request->date,
                'date_fin'   => $request->date_fin,
            ]);
        }

        */

        //return response
        return new PostResource(true, 'mise a jour de actu !', $actulalite);
    }


    public function updateIsVedete(Request $request)
    {

    $actulalite=Actualite::find($request->id);
        //update post with new image
        $actulalite->update([
            'isvedette'   => $request->isvedette,
        ]);


        //return response
        return new PostResource(true, 'Data Post !', $actulalite);
    }

    /**
     * destroy
     *
     * @param  mixed $actulalite
     * @return void
     */
    public function destroy(Actualite $actulalite,$id)
    {
        $actulalite=Actualite::find($id);
        //delete image
        Storage::delete('public/posts/'.$actulalite->image);

        //delete post
        $actulalite->delete();

        //return response
        return new PostResource(true, 'Data Post !', null);
    }
}
