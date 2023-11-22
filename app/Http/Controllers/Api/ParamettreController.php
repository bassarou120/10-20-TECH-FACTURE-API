<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Paramettre;

use App\Models\ParamImage;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ParamettreController extends Controller
{


    public function getStatistque(){


      $data['nbr_adherant'] = DB::table('adherants')->count();

      $event1= DB::table('actualites')
          ->where('type', '=', "JOURNEE-COOPERATION")
          ->count();
      $event2= DB::table('actualites')
                  ->where('type', '=', "JOURNEE-HOSPITALIERE")
                  ->count();
      $event3= DB::table('actualites')
                  ->where('type', '=', "AUTRE-EVERNEMENT")
                  ->count();
      $event4= DB::table('actualites')
                  ->where('type', '=', "JOURNEE-SCIENTIFIQUES")
                  ->count();

        $data['nbr_event']=$event1+$event2+$event3+$event4;
        $data['nbr_formation']=   DB::table('actualites')
            ->where('type', '=', "FORMATION")
            ->count();



        return new PostResource(true, 'param par key', $data);

    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $paramettre = Paramettre::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data param', $paramettre);
    }


    public function getParamettreByKey(Request $request)
    {
        //get posts
        $param=DB::table('paramettres')
            ->where('key', '=', $request->key)
            ->orderBy('id', 'desc')
            ->get()->first() ;

        //return collection of posts as a resource
        return new PostResource(true, 'param par key', $param);
    }



    public function updatParamettreByKey(Request $request){

        $param=DB::table('paramettres')
            ->where('key', '=', $request->key)
            ->orderBy('id', 'desc')
            ->get()->first() ;

        if ($param ==null){
            $newParam=Paramettre::create([

                'key'     => $request->key,
                'value'     => $request->value,

            ]);
            return new PostResource(true, 'param enregister', $newParam);
        }else{
                $newParam=Paramettre::find($param->id);
                 $newParam->update([
                    'key'     => $request->key,
                    'value'     => $request->value,
                ]);

                return new PostResource(true, 'parame enregister', $newParam);


        }







    }

public function saveParamettreSite(Request $request){



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

            'key' => 'required',
            'value' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $paramettre = Paramettre::create([

            'key'     => $request->key,
            'value'   => $request->value,
        ]);

        //return response
        return new PostResource(true, 'Data param  !', $paramettre);
    }

    /**
     * show
     *
     * @param  mixed $paramettre
     * @return void
     */
    public function show(Paramettre $paramettre)
    {
        //return single post as a resource
        return new PostResource(true, 'Data param !', $paramettre);
    }


    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $paramettre
     * @return void
     */
    public function update(Request $request, Paramettre $paramettre)
    {

        //define validation rules
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'value' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $paramettre = Paramettre::update([
            'key'     => $request->key,
            'value'   => $request->value,
        ]);

        //return response
        return new PostResource(true, 'Data param  !', $paramettre);



    }




}
