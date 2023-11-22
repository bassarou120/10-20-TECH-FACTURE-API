<?php

namespace App\Http\Controllers\Api;;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Actualite;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
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
        $document = Document::latest()->paginate(100);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Document', $document);
    }


    public function listDocumentByType(Request $request)
    {
        //get posts
        $document =   DB::table('documents')
            ->where('type', '=', $request->type)
            ->orderBy('id', 'desc')
            ->get();


        //return collection of posts as a resource
        return new PostResource(true, 'List Data Document', $document);
    }


    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function saveDocument(Request $request)
    {

        //define validation rules
        $validator = Validator::make($request->all(), [
//            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'titre' => 'required',
            'type' => 'required',

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
            $image->storeAs('public/document', $image->hashName());

            $imgName= $image->hashName();

        }



        //check if file is not empty
        if ($request->hasFile('fichier')) {
            //upload image
            $fichier = $request->file('fichier');
            $fichier->storeAs('public/document', $fichier->hashName());

            $fileName= $fichier->hashName();

        }

        //create post
        $doc = Document::create([

            'titre'     => $request->titre,
            'type'     => $request->type,
            'image'     =>$imgName,
            'fichier'   => $fileName,
        ]);

        //return response
        return new PostResource(true, 'Data Doc  !', $doc);



    }


}
