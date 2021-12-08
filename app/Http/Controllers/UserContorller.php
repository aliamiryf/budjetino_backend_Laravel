<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
//use phpseclib3\Crypt\Hash
use Illuminate\Support\Facades\Hash;

class UserContorller extends Controller
{
    public function signin(Request $request)
    {
//        return  $request;
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'tell'=>$request->tell,
        ]);
        return response()->json(['message'=>'success'])->setStatusCode(202);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'tell'=>'required|',
        ]);
        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->tell = $request->tell;
        $user->save();
        return $user;
    }
}
