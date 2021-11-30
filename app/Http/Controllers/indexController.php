<?php

namespace App\Http\Controllers;

use App\Models\Transacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class indexController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $enter = 0;
        $enter_lastM = 0;
        $exit = 0;
        $exit_lastM = 0;
        $user = $request->user();
        $transactions = $user->transactions;
        $month = Date::today()->month;
        $lastmonth = Transacion::where('user_id', $user->id)->whereMonth('date', 11)->get();
        $today = Transacion::where('user_id', $user->id)->where('created_at', Date::today())->with('transactionable')->get();
        foreach ($lastmonth as $item) {
            $test = $item->amount;
            $nochar = str_replace(',', '', $test);
            if ($item->type == "enter") {
                $enter_lastM = $enter_lastM + $nochar ;
            } else {
                $exit_lastM = $exit_lastM + $nochar;
            }
        }

        foreach ($transactions as $item) {
            $test = $item->amount;
            $nochar = str_replace(',', '', $test);
            if ($item->type == "enter") {
                $enter = $enter + $nochar;
            } else {
                $exit = $exit + $nochar;
            }
        }

//        array_push($data , );
            return response()->json([
                'folder' => count($user->folders),
                'cart' => count($user->cards),
                'enter' => number_format($enter),
                'exit' =>number_format($exit),
                'enter_LastMonth' => number_format($enter_lastM),
                'exit_LastMonth' => number_format($exit_lastM),
                'today' => $today,
                'carts'=>$user->cards,
                'folders'=>$user->folders,
                'name'=>$request->user()->name,
                'tell'=>$request->user()->tell,
            ]);
    }
}
