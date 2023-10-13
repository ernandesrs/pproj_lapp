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
        $validated['verification_token'] = $this->verificationToken();

        $user = User::create($validated);

        if ($user && $sendVerificationLink) {
            event(new \App\Events\Account\UserRegisteredEvent($user));
        }

        return $user ?? null;
    }

    /**
     * Register verify
     *
     * @param User|\Illuminate\Contracts\Auth\Authenticatable $user
     * @param string $token
     * @return bool
     */
    public function registerVerify(User|\Illuminate\Contracts\Auth\Authenticatable $user, string $token)
    {
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
     * @param User|\Illuminate\Contracts\Auth\Authenticatable $user
     * @return bool
     */
    public function resendVerificationLink(User|\Illuminate\Contracts\Auth\Authenticatable $user)
    {
        // Account has been verified
        if ($user->email_verified_at) {
            throw new \App\Exceptions\Account\HasAlreadyBeenVerifiedException;
        }

        // Check last email sent date
        [, $date] = explode('|', $user->verification_token);
        if (\Illuminate\Support\Carbon::parse(base64_decode($date))->addMinutes(1)->isFuture()) {
            return false;
        }

        // Create a new token and resent verification mail
        $user->verification_token = $this->verificationToken();
        $user->save();

        event(new \App\Events\Account\VerificationLinkResendEvent($user));

        return true;
    }

    /**
     * Generate a verification token
     *
     * @return string
     */
    private function verificationToken()
    {
        return Str::random(20) . '|' . base64_encode(\Illuminate\Support\Carbon::now());
    }
}