<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\User;

class UserService
{
    /**
     * Users photo directory
     */
    private $photosDir = 'users/photos';

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
     * Update user
     *
     * @param User|\Illuminate\Contracts\Auth\Authenticatable $user
     * @param array $validated
     * @return User|\Illuminate\Contracts\Auth\Authenticatable $user
     */
    public function update(User|\Illuminate\Contracts\Auth\Authenticatable $user, array $validated)
    {
        if ($validated['password'] ?? null) {
            $validated['password'] = \Hash::make($validated['password']);
        }

        $user->update($validated);

        return $user;
    }

    /**
     * Photo upload
     *
     * @param User|\Illuminate\Contracts\Auth\Authenticatable $user
     * @param array $validated
     * @return User
     */
    public function photoUpload(User|\Illuminate\Contracts\Auth\Authenticatable $user, array $validated)
    {
        /**
         * @var \Illuminate\Http\UploadedFile
         */
        $photo = $validated['photo'];

        $user = $this->deletePhoto($user, false);
        if ($path = $photo->store($this->photosDir, 'public')) {
            $user->photo = $path;
            $user->save();
        }

        return $user;
    }

    /**
     * User photo delete
     *
     * @param User $user
     * @param bool $deleteAndSave
     * @return User
     */
    private function deletePhoto(User $user, bool $deleteAndSave = true)
    {
        if (is_null($user->photo)) {
            return $user;
        }

        if (\Storage::disk('public')->exists($user->photo)) {
            \Storage::disk('public')->delete($user->photo);
        }

        $user->photo = null;
        if ($deleteAndSave) {
            $user->save();
        }

        return $user;
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