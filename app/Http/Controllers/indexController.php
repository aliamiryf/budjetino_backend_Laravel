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
        $exit_lastM=0;
        $user = $request->user();
        $transactions = $user->transactions ;
        $month = Date::today()->month;

        $lastmonth = Transacion::where('user_id',$user->id)->whereMonth('date',$month)->get();
        $today = Transacion::where('user_id',$user->id)->where('created_at',Date::today())->get();


//        return $lastmonth;
        foreach ($lastmonth as $item){
            if ($item->type == "enter"){
                $enter_lastM = $enter_lastM + $item->amount;
            }
            else{
                $exit_lastM = $exit_lastM + $item->amount;

            }
        }
        foreach ($transactions as $item){
            if ($item->type == "enter"){
                $enter = $enter + $item->amount;
            }
            else{
                $exit = $exit + $item->amount;
            }
        }
        array_push($data , [
            'folder'=>count($user->folders),
            'cart'=>count($user->cards),
            'enter'=>$enter,
            'exit'=>$exit,
            'enter_LastMonth'=>$enter_lastM,
            'exit_LastMonth'=>$exit_lastM,
            'today'=>$today,
        ]);
        return $data;
    }
}
