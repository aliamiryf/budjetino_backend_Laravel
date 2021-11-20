<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Folder;
use App\Models\Transacion;
use Illuminate\Http\Request;

class transactionContrller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transacion::find(1)->transactionable;
        return $transactions;
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
        $type = "";
        if ($request->has('card_id')){
            $type = Card::find($request->card_id);
        }
        if ($request->has('folder_id')){
            $type = Folder::find($request->card_id);
        }
        $transactions = new Transacion([
            'amount'=>$request->amount,
            'title'=>$request->title,
            'date'=>$request->date,
            'user_id'=>$request->user()->id,
            'type'=>$request->type,
        ]);
//        return $type;
        $responce = $type->transactions()->save($transactions);
        return response()->json($responce);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
