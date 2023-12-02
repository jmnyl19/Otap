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
    // Route::get('/getlatestincidents', 'IncidentController@getLatestIncidents');
});
Route::get('/forwarded', [App\Http\Controllers\IncidentController::class, 'manageforwarded'])->name('forwarded');
Route::get('/forwardedreports', [App\Http\Controllers\ReportController::class, 'manageforward'])->name('forwardedreports');
Route::get('/received', [App\Http\Controllers\IncidentController::class, 'managereceived'])->name('received');
Route::get('/getlatestincidents', [App\Http\Controllers\IncidentController::class, 'getLatestIncidents']);
Route::get('/currentincident/{id}', [App\Http\Controllers\IncidentController::class, 'getCurrentIncident']);
Route::group(['middleware' => ['auth']], function() {
    Route::get('admin/index', [App\Http\Controllers\IncidentController::class, 'adminLanding'])->name('landingpage');
    Route::post('respond/{id}', [App\Http\Controllers\StatusController::class, 'respond']);
    Route::post('responded/{id}', [App\Http\Controllers\StatusController::class, 'responded']);
    Route::post('responding/{id}', [App\Http\Controllers\StatusController::class, 'responding']);
    Route::post('respondreport/{id}', [App\Http\Controllers\StatusController::class, 'respondreport']);
    Route::post('forward/{id}', [App\Http\Controllers\StatusController::class, 'forward']);
    Route::post('reforward/{id}', [App\Http\Controllers\StatusController::class, 'reforward']);
    Route::post('forwarded/{id}', [App\Http\Controllers\StatusController::class, 'forwarded']);
    Route::post('reforwarded/{id}', [App\Http\Controllers\StatusController::class, 'reforwarded']);
    Route::post('completed/{id}', [App\Http\Controllers\StatusController::class, 'completed']);
    Route::post('forcompleted/{id}', [App\Http\Controllers\StatusController::class, 'forcompleted']);
    Route::post('completing/{id}', [App\Http\Controllers\StatusController::class, 'completing']);
    Route::post('completedreport/{id}', [App\Http\Controllers\StatusController::class, 'completedreport']);

    Route::get('/pendingpage', [App\Http\Controllers\IncidentController::class, 'managepending'])->name('pendingpage');
    Route::get('/completedpage', [App\Http\Controllers\IncidentController::class, 'managecompleted'])->name('completedpage');
    Route::get('/responding', [App\Http\Controllers\IncidentController::class, 'manageresponding'])->name('responding');
    Route::get('/latest', [App\Http\Controllers\ReportController::class, 'index'])->name('latest');
    Route::get('/respondedreports', [App\Http\Controllers\ReportController::class, 'respondedreports'])->name('respondedreports');
    Route::get('/completedreports', [App\Http\Controllers\ReportController::class, 'completedreports'])->name('completedreports');

});

