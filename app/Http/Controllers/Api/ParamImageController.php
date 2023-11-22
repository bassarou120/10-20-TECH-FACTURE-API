<?php

namespace App\Http\Controllers\Api;


use App\Models\Actualite;
use App\Models\ParamImage;
use App\Models\Reshaoc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ParamImageController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $allImage = ParamImage::latest()->paginate(100);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $allImage);
    }

  public function getImageByType(Request $request)
    {
        //get posts
        $image=DB::table('param_images')
            ->where('type', '=', $request->type)
            ->orderBy('id', 'desc')
            ->get()->first() ;

        //return collection of posts as a resource
        return new PostResource(true, 'image par type', $image);
    }



    public function updateOrSaveImage(Request $request){

        $image=DB::table('param_images')
            ->where('type', '=', $request->type)
            ->orderBy('id', 'desc')
            ->get()->first() ;



        if ($image ==null){

            //check if image is not empty
            if ($request->hasFile('image')) {
                //upload image
                $myimage = $request->file('image');
                $myimage->storeAs('public/param_image', $myimage->hashName());

                $imgName= $myimage->hashName();

            }

            $newImag=ParamImage::create([
                'image'     =>$imgName,
                'title'     => $request->title,
                'type'     => $request->type,

            ]);

            return new PostResource(true, 'image enregister', $newImag);

        }else{

            if ($request->hasFile('image')) {


                $newImag=ParamImage::find($image->id);
                //upload image
                $myimage = $request->file('image');
                $myimage->storeAs('public/param_image', $myimage->hashName());
                $imgName = $myimage->hashName();

                //delete old image
                Storage::delete('public/param_image/' . $image->image);

                $newImag->update([
                    'image'     =>$imgName,
                    'title'     => $request->title,
                    'type'     => $request->type,

                ]);

                return new PostResource(true, 'image enregister', $newImag);
            }





        }







    }


}
