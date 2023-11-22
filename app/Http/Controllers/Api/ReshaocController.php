<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Reshaoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReshaocController extends Controller
{

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //

        $lastrecord= Reshaoc::latest()->first();
        return new PostResource(true, 'Laste record of reshaoc', $lastrecord);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reshaoc  $reshaoc
     * @return \Illuminate\Http\Response
     */
    public function show(Reshaoc $reshaoc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reshaoc  $reshaoc
     * @return \Illuminate\Http\Response
     */
    public function edit(Reshaoc $reshaoc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reshaoc  $reshaoc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reshaoc $reshaoc)
    {
        $validator = Validator::make($request->all(), [

            'type'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        switch ($request->type){
            case "presentation":
                $reshaoc->update(["presentation"=>$request->content]);
                break;
           case "mission":
               $reshaoc->update(["mission"=>$request->content]);
                break;
           case "objectif":
               $reshaoc->update(["objectif"=>$request->content]);
                break;
           case "organisation":
               $reshaoc->update(["organisation"=>$request->content]);
                break;
           case "plan":
               $reshaoc->update(["plan"=>$request->content]);
                break;

        }



        return new PostResource(true, 'update ok', $reshaoc);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reshaoc  $reshaoc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reshaoc $reshaoc)
    {
        //
    }
}
