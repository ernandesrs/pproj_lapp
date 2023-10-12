<?php

use App\Http\Controllers\Account\RegisterController;
use App\Http\Controllers\LappController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

\Auth::attempt(['email' => 'psnaomeaaaba@mail.com', 'password' => 'ernandes']);

Route::get('/', [LappController::class, 'index']);
Route::group([
    'prefix' => 'account'
], function () {

    Route::post('register', [RegisterController::class, 'register']);
    Route::patch('register-verify/{token}', [RegisterController::class, 'registerVerify'])
        ->middleware(['auth']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});