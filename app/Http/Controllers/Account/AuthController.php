<?php

namespace App\Http\Controllers\Account;

use App\Exceptions\Account\EmailOrPasswordInvalidException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use App\Http\Requests\Account\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use TraitApiController;

    /**
     * Login
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        ['email' => $email, 'password' => $password] = $request->validated();

        $user = User::where(['email' => $email])->first();
        if (!$user || !\Auth::attempt(['email' => $email, 'password' => $password])) {
            throw new EmailOrPasswordInvalidException;
        }

        $token = $user->createToken(strtolower(config('app.name')) . '_auth');

        return $this->success([
            'token' => 'Bearer ' . $token->plainTextToken
        ]);
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        \Auth::user()->currentAccessToken()->delete();
        return $this->success();
    }
}