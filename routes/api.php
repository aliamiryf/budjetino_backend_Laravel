<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::resource('/product','App\Http\Controllers\productController');
Route::get('test',function (){
    return "ssssss";
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//    return \App\Models\Card::all();
});
Route::middleware('auth:api')->prefix('v1')->group(function (){
    Route::post('/insert_user',function (Request $request){
        return \App\Models\Folder::all();
    });
    Route::resource('/transaction','App\Http\Controllers\transactionContrller');
    Route::resource('/card','App\Http\Controllers\cardController');
    Route::get('cards/restore/{id}','App\Http\Controllers\cardController@restore');
    Route::get('cards/force/{id}','App\Http\Controllers\cardController@force');
    Route::resource('/folder','App\Http\Controllers\folderController');
});
