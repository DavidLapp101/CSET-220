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

Route::get('/land', function () {
    return view('landing-page');
});

Route::get('/newAppointment', function () {
    return view('doctor-appointment');
});

Route::get('/role', function () {
    return view('roles');
});

Route::get('/patientHome', function () {
    return view('patient-home');
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