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
    $ua = \App\Models\User::where('id', 1)->first();
    $ub = \App\Models\User::where('id', 2)->first();
    $uc = \App\Models\User::where('id', 3)->first();

    // $ua->roles()->attach([1]);
    // $ub->roles()->attach([2]);
    // $uc->roles()->attach([3]);

    var_dump(
        $ua->roles()->first()->users()->get(),
        $ub->roles()->first()->users()->get(),
        $uc->roles()->first()->users()->get(),
    );
    die;
    return view('welcome');
});

Route::get('/mailable', function () {
    $user = \App\Models\User::where('email', 'johnl@mail.com')->first();

    $reset = \App\Models\Account\PasswordReset::where('email', $user->email)->first();

    return new \App\Mail\Account\UpdatePasswordMail($user, $reset);
});
