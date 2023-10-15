<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\TraitApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use TraitApiController;

    /**
     * Register account
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        return $this->success([
            'user' => new UserResource((new UserService)->register($request->validated()))
        ]);
    }

    /**
     * Register verify
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerVerify(string $token)
    {
        (new UserService)->registerVerify(\Auth::user(), $token);

        return $this->success();
    }

    /**
     * Resend verification link
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendVerificationLink()
    {
        (new UserService)->resendVerificationLink(\Auth::user());

        return $this->success();
    }
}