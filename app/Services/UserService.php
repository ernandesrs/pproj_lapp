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

    /**
     * Register verify
     *
     * @param string $token
     * @return bool
     */
    public function registerVerify(string $token)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = \Auth::user();

        if ($user->email_verified_at) {
            throw new \App\Exceptions\Account\HasAlreadyBeenVerifiedException;
        }

        if ($user->verification_token !== $token) {
            throw new \App\Exceptions\Account\InvalidRegisterVerificationTokenException;
        }

        $user->verification_token = null;
        $user->email_verified_at = \Illuminate\Support\Carbon::now();

        return $user->save();
    }

    /**
     * Resend verification link
     *
     * @return bool
     */
    public function resendVerificationLink()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = \Auth::user();

        if ($user->email_verified_at) {
            throw new \App\Exceptions\Account\HasAlreadyBeenVerifiedException;
        }

        $user->verification_token = Str::random(50);
        $user->save();

        event(new \App\Events\Account\VerificationLinkResendEvent($user));

        return true;
    }
}