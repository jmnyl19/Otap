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
Route::get('/getChartData', [App\Http\Controllers\ChartController::class, 'getChartData']);
Route::get('/getPieData', [App\Http\Controllers\ChartController::class, 'getPieData']);

Route::get('/forwarded', [App\Http\Controllers\IncidentController::class, 'manageforwarded'])->name('forwarded');
Route::get('/forwardedreports', [App\Http\Controllers\ReportController::class, 'manageforward'])->name('forwardedreports');
Route::get('/received', [App\Http\Controllers\IncidentController::class, 'managereceived'])->name('received');
Route::get('/getlatestincidents', [App\Http\Controllers\IncidentController::class, 'getLatestIncidents']);
Route::get('/getlatestforwarded', [App\Http\Controllers\IncidentController::class, 'getLatestForwardedIncidents']);
Route::get('/getpending', [App\Http\Controllers\IncidentController::class, 'getpendingIncidents']);
Route::get('/getpendingforwarded', [App\Http\Controllers\IncidentController::class, 'getpendingForwarded']);
Route::get('/getresponding', [App\Http\Controllers\IncidentController::class, 'getResponding']);
Route::get('/getrespondingforwarded', [App\Http\Controllers\IncidentController::class, 'getRespondingForwarded']);
Route::get('/getforwarded', [App\Http\Controllers\IncidentController::class, 'getForwarded']);
Route::get('/getreforwarded', [App\Http\Controllers\IncidentController::class, 'getreForwarded']);
Route::get('/getcompleted', [App\Http\Controllers\IncidentController::class, 'getCompleted']);
Route::get('/getcompletedforwarded', [App\Http\Controllers\IncidentController::class, 'getCompletedForwarded']);
Route::get('/getreceived', [App\Http\Controllers\IncidentController::class, 'getReceived']);
Route::get('/getreport', [App\Http\Controllers\IncidentController::class, 'getReport']);
Route::get('/getforwardedreport', [App\Http\Controllers\IncidentController::class, 'getForwardedReport']);
Route::get('/getrespondingreport', [App\Http\Controllers\IncidentController::class, 'getRespondingReport']);
Route::get('/getforwardreport', [App\Http\Controllers\IncidentController::class, 'getForwardReport']);
Route::get('/getreforwardreport', [App\Http\Controllers\IncidentController::class, 'getReForwardReport']);
Route::get('/getcompletedreport', [App\Http\Controllers\IncidentController::class, 'getCompletedReport']);
Route::get('/getcompletedforwardedreport', [App\Http\Controllers\IncidentController::class, 'getCompletedForwardReport']);

Route::get('/reforwarded/{id}', [App\Http\Controllers\IncidentController::class, 'reForwarded']);
Route::get('/completedreport/{id}', [App\Http\Controllers\IncidentController::class, 'completedReport']);
Route::get('/completedforwardedreport/{id}', [App\Http\Controllers\IncidentController::class, 'completedForwardReport']);
Route::get('/reforwardreport/{id}', [App\Http\Controllers\IncidentController::class, 'reforwardReport']);
Route::get('/forwardreport/{id}', [App\Http\Controllers\IncidentController::class, 'forwardReport']);
Route::get('/respondingreport/{id}', [App\Http\Controllers\IncidentController::class, 'RespondingReport']);
Route::get('/respondingforwardedreport/{id}', [App\Http\Controllers\IncidentController::class, 'RespondingForwardedReport']);
Route::get('/forwardedreport/{id}', [App\Http\Controllers\IncidentController::class, 'ForwardedReport']);
Route::get('/pendingreport/{id}', [App\Http\Controllers\IncidentController::class, 'PendingReport']);
Route::get('/receivedincident/{id}', [App\Http\Controllers\IncidentController::class, 'ReceivedIncident']);
Route::get('/completedincident/{id}', [App\Http\Controllers\IncidentController::class, 'completedIncident']);
Route::get('/completedforwarded/{id}', [App\Http\Controllers\IncidentController::class, 'completedForwarded']);
Route::get('/forwardedincident/{id}', [App\Http\Controllers\IncidentController::class, 'getForwardedIncident']);
Route::get('/respondingforwarded/{id}', [App\Http\Controllers\IncidentController::class, 'RespondingForwarded']);
Route::get('/respondingincident/{id}', [App\Http\Controllers\IncidentController::class, 'RespondingIncident']);
Route::get('/currentforwarded/{id}', [App\Http\Controllers\IncidentController::class, 'getCurrentForwarded']);
Route::get('/currentincident/{id}', [App\Http\Controllers\IncidentController::class, 'getCurrentIncident']);
Route::get('/pendingforwarded/{id}', [App\Http\Controllers\IncidentController::class, 'PendingForwarded']);
Route::get('/pendingincident/{id}', [App\Http\Controllers\IncidentController::class, 'PendingIncident']);
Route::get('/getrespondingforwardedreport', [App\Http\Controllers\IncidentController::class, 'getRespondingForwardedReport']);
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

