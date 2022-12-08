<?php
use App\Http\Controllers\FinalController;
use App\Http\Controllers\patientinfoController;
use Illuminate\Support\Facades\Route;

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
    return view('login-register');

});
 Route::get('/index', function () {
    return view('index');
 });
 
//     return view('login-register');
// });

Route::get('/patientInfo', function(){
    return view('patientinfo');
});

Route::get('/land', [patientinfoController::class, 'land']);

Route::get('/newAppointment', [patientinfoController::class, 'appointmentPaintent']);

Route::get('/role', function () {
    return view('roles');
});

Route::get('/employees', [patientinfoController::class, 'listEmployees']);

Route::get('/patientSearch', [patientinfoController::class, 'listPatients']);

Route::get('/accountApproval',[patientinfoController::class, 'pendingUsers' ]);

// route::post('/acceptDecline', [FinalController::class, 'acceptDeclineUsers']);

Route::get('/newRoster',[patientinfoController::class, 'createRoster']);

Route::get('/patientOfDoctor', function () {
    return view('patient-of-doctor');
});

Route::get('/payments',[patientinfoController::class, 'patientBalances']);

Route::get('/roster', [patientinfoController::class, 'showRoster']);
