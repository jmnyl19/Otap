<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\StatusController;
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

Route::group(['namespace' => 'App\Http\Controllers'], function ()
{
    
    Route::get('/login', 'LoginController@show')->name('login.show');
    Route::post('/userlogin', 'UserLoginController@userlogin');
    Route::post('/register', 'RegisterController@register');
    Route::post('/sendreport', 'IncidentController@create');
    Route::post('/reportincident', 'ReportController@create');
    Route::get('/emergency/{id}', 'IncidentController@user_emegency_history');
    Route::get('/incident/{id}', 'IncidentController@user_incident_history');
    Route::get('/user/{id}', 'UserLoginController@userAccount');
    Route::patch('/userEdit/{id}', 'UserLoginController@userEdit');
});


Route::post('complaints/create',function(Request $request){
    $complaints = new \App\Models\Complaint;
    $complaints ->fill($request->all());
    $complaints ->save();

    return $complaints;
});

Route::patch('cancelled/{id}', [App\Http\Controllers\StatusController::class, 'cancelled']);
Route::patch('cancelledIncident/{id}', [App\Http\Controllers\StatusController::class, 'cancelledIncident']);