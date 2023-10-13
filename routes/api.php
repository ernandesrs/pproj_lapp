<?php

use App\Http\Controllers\Account\LoginController;
use App\Http\Controllers\Account\RegisterController;
use App\Http\Controllers\LappController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [LappController::class, 'index']);
Route::group([
    'prefix' => 'account'
], function () {

    Route::group([
        'prefix' => 'register'
    ], function () {

        Route::post('/', [RegisterController::class, 'register']);
        Route::patch('verify/{token}', [RegisterController::class, 'registerVerify'])
            ->middleware(['auth:sanctum']);
        Route::get('resend-verification-link', [RegisterController::class, 'resendVerificationLink'])
            ->middleware(['auth:sanctum']);

    });

    Route::group([
        'prefix' => 'auth'
    ], function () {

        Route::post('login', [LoginController::class, 'login']);
        Route::post('logout', [LoginController::class, 'logout'])
            ->middleware(['auth:sanctum']);

    });

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});