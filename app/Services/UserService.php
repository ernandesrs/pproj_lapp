<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\User;

class UserService
{
    /**
     * Register
     *
     * @param array $validated
     * @param boolean $sendVerificationLink
     * @return null|User
     */
    public function register(array $validated, bool $sendVerificationLink = true)
    {
        $validated['password'] = \Hash::make($validated['password']);
        $validated['verification_token'] = Str::random(50);

        $user = User::create($validated);

        if ($user && $sendVerificationLink) {
            event(new \App\Events\Account\UserRegisteredEvent($user));
        }

        return $user ?? null;
    }
}