<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPassword;
use App\Http\Controllers\Register;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgetPassword;

//genggeng

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/landingpage', [App\Http\Controllers\IncidentController::class,'index'])->name('landingpage');
Route::get('/forwarded', [App\Http\Controllers\IncidentController::class,'manageforwarded'])->name('forwarded');
Route::get('/latest', [App\Http\Controllers\ReportController::class,'index'])->name('latest');

Route::get('incidents', [App\Http\Controllers\LoginController::class, 'index'])->name('landingpage');
Route::get('staritaadmin', [App\Http\Controllers\LoginController::class, 'staritaadmin'])->name('landingpage');
Route::get('etapinacadmin', [App\Http\Controllers\LoginController::class, 'etapinacadmin'])->name('secadminpage');

Route::group(['namespace' => 'App\Http\Controllers'], function ()
{
    Route::get('/welcome', 'LoginController@show')->name('login.show');
    Route::post('/welcome', 'LoginController@login')->name('login.perform');
    // Route::get('/login/admin', 'LoginController@showAdmin')->name('login.showAdmin');
    // Route::post('/ticketpage', 'Ticket@register')->name('ticket.perform');
    Route::get('/logout', 'LoginController@logout')->name('logout');
});

// Route::group(['middleware' => ['auth']], function() {
//     Route::post('raised/{id}', [App\Http\Controllers\LoginController::class, 'raised']);
//     Route::post('disregard/{id}', [App\Http\Controllers\LoginController::class, 'disregard']);
//     Route::post('acknowledge/{id}', [App\Http\Controllers\LoginController::class, 'acknowledge']);
//     Route::post('dealt/{id}', [App\Http\Controllers\LoginController::class, 'dealt']);

// });

