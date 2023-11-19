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

// Route::get('/landingpage', [App\Http\Controllers\IncidentController::class, 'index']);
Route::get('/forwarded', [App\Http\Controllers\IncidentController::class, 'manageforwarded'])->name('forwarded');
Route::get('/secforwarded', [App\Http\Controllers\IncidentController::class, 'managesecforwarded'])->name('secforwarded');
Route::get('/latest', [App\Http\Controllers\ReportController::class, 'index'])->name('latest');
Route::get('/seclatest', [App\Http\Controllers\ReportController::class, 'managelatest'])->name('seclatest');
// Route::get('pending', [App\Http\Controllers\IncidentController::class, 'pending']);

// Route::get('incidents', [App\Http\Controllers\LoginController::class, 'index'])->name('landingpage');
// Route::get('staritaadmin', [App\Http\Controllers\LoginController::class, 'staritaadmin'])->name('landingpage');
// Route::get('etapinacadmin', [App\Http\Controllers\LoginController::class, 'etapinacadmin'])->name('secadminpage');



Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/welcome', 'LoginController@show')->name('login.show');
    Route::post('/login', 'LoginController@login')->name('login.perform');
    // Route::get('/login/admin', 'LoginController@showAdmin')->name('login.showAdmin');
    // Route::post('/ticketpage', 'Ticket@register')->name('ticket.perform');
    Route::get('/logout', 'LoginController@logout')->name('logout');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('admin/index', [App\Http\Controllers\IncidentController::class, 'adminLanding'])->name('landingpage');

});
