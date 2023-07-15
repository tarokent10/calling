<?php

use App\Http\Controllers\PhoneCallController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/phone_calls', [PhoneCallController::class, 'store']);
Route::post('/phone_calls/{id}/cancel', [PhoneCallController::class, 'cancel'])->where(['id' => '[0-9]+']);
