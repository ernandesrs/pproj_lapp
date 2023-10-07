<?php

use App\Http\Controllers\Api\V1\LappController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [LappController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});