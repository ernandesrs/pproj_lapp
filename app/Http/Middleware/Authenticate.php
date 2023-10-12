<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthenticatedException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Unauthenticated
     *
     * @param $request
     * @param array $guards
     * @return void
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new UnauthenticatedException;
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}