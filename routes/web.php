<?php

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

Route::get('/patientInfo', function(){
    return view('patientinfo');
});

Route::get('/land', function () {
    return view('landing-page');
});

Route::get('/newAppointment', function () {
    return view('doctor-appointment');
});

Route::get('/role', function () {
    return view('roles');
});

Route::get('/employees', function () {
    return view('employees');
});

Route::get('/patientSearch', function () {
    return view('patient-search');
});

Route::get('/accountApproval', function () {
    return view('account-approval');
});

Route::get('/newRoster', function () {
    return view('new-roster');
});

Route::get('/patientOfDoctor', function () {
    return view('patient-of-doctor');
});

Route::get('/adminReport', function () {
    return view('admin-report');
});

Route::get('/payments', function () {
    return view('payments');
});

Route::get('/roster', function () {
    return view('roster');
});
