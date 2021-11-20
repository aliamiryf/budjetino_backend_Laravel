<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class folderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data =[];
        $folder = $request->user()->folders;
        foreach ($folder as $item){
            array_push($data , [
                'id'=>$item->id,
                'title'=>$item->title,
                'date'=>Verta::instance($item->created_at)->format("Y   /m/d"),
                'transacions'=>count($item->transactions),
            ]);
        }
        return response()->json($data);
//        return response()->json($request->user()->folders);
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
        $folder = Folder::create([
            'title'=>$request->title,
            'user_id'=>$request->user()->id,
        ]);
        return response()->json(['message'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $data = [];
        $folder = Folder::find($id);
        if ($folder->user_id == $request->user()->id){
            $data = [
                'id'=>$folder->id,
                'title'=>$folder->title,
                'date'=>Verta::instance($folder->created_at)->format('Y/m/d'),
                'transactions'=>$folder->transactions,
            ];
            return  response()->json($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        return $request;
        $folder = Folder::find($id);
        if ($folder->user_id == $request->user()->id){
            $folder->update([
                'title'=>$request->title,
            ]);
            return response()->json(['message'=>'success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $folder = Folder::find($id)->delete();
        return response()->json(['message'=>'success']);

    }
}
