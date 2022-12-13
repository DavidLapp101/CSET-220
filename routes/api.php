<?php

use App\Http\Controllers\FinalController;
use App\Http\Controllers\patientinfoController;
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


Route::post('/register', [FinalController::class, 'register']);
Route::post('/login', [FinalController::class, 'login']);
Route::post('/newRoster', [FinalController::class, 'newRoster']);
Route::post('/newAppointment', [FinalController::class, 'newDoctorsAppointment']);
Route::post('/acceptDecline', [FinalController::class, 'acceptDeclineUsers']);
Route::post('/changeSalary', [FinalController::class, 'changeSalary']);
Route::post('/changeSalary', [FinalController::class, 'changeSalary']);
Route::post('/updateBalance', [FinalController::class, 'updateBalance']);
Route::post('/makePayment', [FinalController::class, 'makePayment']);
Route::post('/updatePatient', [FinalController::class, 'caregiverUpdatePatient']);
Route::post('/addRole', [FinalController::class, 'addRole']);
Route::post('/newRegiment', [FinalController::class, 'newRegiment']);
Route::post('/viewFamilyTasks', [patientinfoController::class, 'viewFamilyTasks']);