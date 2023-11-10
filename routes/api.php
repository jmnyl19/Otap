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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users/create',function(Request $request){
    $users = new \App\Models\User;
    $users->fill($request->all());
    $users->save();

    return $users;
});

Route::post('complaints/create',function(Request $request){
    $complaints = new \App\Models\Complaint;
    $complaints ->fill($request->all());
    $complaints ->save();

    return $complaints;
});
