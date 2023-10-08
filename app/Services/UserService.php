<?php

namespace App\Services;

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
        return User::create($validated);
    }
}