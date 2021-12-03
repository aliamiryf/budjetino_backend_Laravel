<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
//use function Sodium\add;
use Hekmatinasser\Verta\Verta;
class cardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $cart = $request->user()->cards;
//        return $cart;
        foreach ($cart as $item){
            array_push($data,[
                'id'=>$item->id,
                'title'=>$item->title,
                'cart_number'=>$item->cart_number,
                'transactions'=>count($item->transactions),
                'date'=>Verta::instance($item->created_at)->format('Y/m/d'),
            ]);
        }
        return response()->json($data);
//        return response()->json($request->user()->cards);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $card = Card::create([

            'cart_number' => $request->cart_number,
            'title' => $request->title,
            'user_id' => $request->user()->id,
        ]);
        return response()->json(['message' => 'success']);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $reques)
    {
        $data = [];
        $card = Card::find($id);
        $enter = 0;
        $exit = 0;
        $total =0;
//       $card->load('transactions');
        $transactions = $card->transactions;
        foreach ($transactions as $item) {
            $test = $item->amount;
            $nochar = str_replace(',', '', $test);
            if ($item->type == "enter") {
                $enter = $enter + $nochar ;
                $total = $total + $nochar;
            } else {
                $total = $total - $nochar;
                $exit = $exit + $nochar;
            }
        }
        if (isset($card->user)) {
            if ($card->user->id == $reques->user()->id) {
                $data = [
                    'id'=>$card->id,
                    'title' => $card->title,
                    'cart_number' => $card->cart_number,
                    'transactions_count' => count($card->transactions),
                    'enter'=>number_format($enter),
                    'exit'=>number_format($exit),
                    'total'=>number_format($total),
                    'transactions'=>$card->transactions
                ];
            }
        }
        return response()->json($data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
//    public function edit($id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $card = Card::find($id);
        $card->title = $request->title;
        $card->cart_number = $request->cart_number;
        $card->save();
        return response()->json(['message' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $card = Card::find($id)->delete();
        return response()->json(['message' => 'success']);

    }

    public function restore($id, Request $request)
    {
        $card = Card::withTrashed()->find($id)->restore();
        return response()->json(['message' => 'success']);
    }

    public function force($id)
    {
        $card = Card::withTrashed()->find($id)->forceDelete();
        return response()->json(['message' => 'success']);
    }
}
