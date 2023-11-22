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
Route::get('/forwarded', [App\Http\Controllers\IncidentController::class, 'manageforwarded'])->name('forwarded');
Route::group(['middleware' => ['auth']], function() {
    Route::get('admin/index', [App\Http\Controllers\IncidentController::class, 'adminLanding'])->name('landingpage');
    Route::patch('respond/{id}', [App\Http\Controllers\StatusController::class, 'respond']);
    Route::patch('forward/{id}', [App\Http\Controllers\StatusController::class, 'forward']);
    Route::patch('completed/{id}', [App\Http\Controllers\StatusController::class, 'completed']);

   
    Route::get('/pendingpage', [App\Http\Controllers\IncidentController::class, 'managepending'])->name('pendingpage');
    Route::get('/completedpage', [App\Http\Controllers\IncidentController::class, 'managecompleted'])->name('completedpage');
    Route::get('/responding', [App\Http\Controllers\IncidentController::class, 'manageresponding'])->name('responding');
    Route::get('/latest', [App\Http\Controllers\ReportController::class, 'index'])->name('latest');
});

