<?php

use App\Http\Controllers\Account\AuthController;
use App\Http\Controllers\Account\ForgetController;
use App\Http\Controllers\Account\MeController;
use App\Http\Controllers\Account\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\Setting\EmailSenderController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LappController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [LappController::class, 'index']);

/**
 * 
 * Account
 * 
 */
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

        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])
            ->middleware(['auth:sanctum']);

    });

    Route::group([
        'prefix' => 'password'
    ], function () {

        Route::post('forget', [ForgetController::class, 'forget']);
        Route::post('update/{token}', [ForgetController::class, 'update']);

    });

    Route::group([
        'prefix' => 'me',
        'middleware' => 'auth:sanctum'
    ], function () {

        Route::get('/', [MeController::class, 'me']);
        Route::post('update', [MeController::class, 'update']);
        Route::post('update-password', [MeController::class, 'updatePassword']);
        Route::post('photo', [MeController::class, 'photoUpload']);
        Route::delete('photo', [MeController::class, 'photoDelete']);

    });

});

/**
 * 
 * Admin
 * 
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth:sanctum']
], function () {

    Route::get('/', [AdminController::class, 'index']);

    /**
     * 
     * Users
     * 
     */
    Route::apiResource('users', UserController::class);
    Route::get('admins', [UserController::class, 'admins']);
    Route::delete('users/{user}/photo', [UserController::class, 'photoDelete']);
    Route::patch('users/{user}/role/{role}', [UserController::class, 'addRole']);
    Route::delete('users/{user}/role/{role}', [UserController::class, 'removeRole']);

    /**
     * 
     * Roles
     * 
     */
    Route::apiResource('roles', RoleController::class);

    Route::apiResource('settings', SettingController::class)
        ->except(['store', 'update', 'delete', 'show']);

    Route::apiResource('settings/email-senders', EmailSenderController::class);
    Route::patch('settings/email-senders/{emailSender}/default', [EmailSenderController::class, 'makeDefault']);


});