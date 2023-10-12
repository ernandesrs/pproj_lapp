<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\User;

class UserService
{
    /**
     * Register user
     *
     * @param array $validated
     * @return User
     */
    public function register(array $validated)
    {
        $validated['password'] = \Hash::make($validated['password']);
        $validated['verification_token'] = Str::random(50);

        return User::create($validated);
    }
}