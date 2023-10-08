<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\RegisterRequest;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use ApiController;

    /**
     * Register account
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        var_dump($request->validated());
        return $this->success();
    }
}