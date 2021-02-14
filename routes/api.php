<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Appointment;
use App\Http\Controllers\AppointmentController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Store Name (stor_nme) :
// strip
// browhaus

Route::get('/locations/{stor_nme?}', [AppointmentController::class, 'locations']);
Route::get('/time/{locn_cde?}/{day_numb?}', [AppointmentController::class, 'time']);

Route::post('/appointment/create', [AppointmentController::class, 'save']);

Route::get('/appointments/{stor_nme?}', [AppointmentController::class, 'appointments']);
