<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mailable', function () {
    $user = \App\Models\User::where('email', 'johnl@mail.com')->first();

    $reset = \App\Models\Account\PasswordReset::where('email', $user->email)->first();

    return new \App\Mail\Account\UpdatePasswordMail($user, $reset);
});
