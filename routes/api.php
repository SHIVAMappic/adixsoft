<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/user-email-verify', [App\Http\Controllers\Api\OtpController::class, 'userEmailVerify'])->name('user-email-verify');
Route::post('/user-otp-verify', [App\Http\Controllers\Api\OtpController::class, 'userOtpVerify'])->name('user-otp-verify');
Route::post('/resend-otp', [App\Http\Controllers\Api\OtpController::class, 'resendOtp'])->name('resend-otp');