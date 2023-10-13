<?php

namespace App\Exceptions;

use App\Exceptions\Account\EmailOrPasswordInvalidException;
use App\Exceptions\Account\HasAlreadyBeenVerifiedException;
use App\Exceptions\Account\InvalidRegisterVerificationTokenException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Dont report
     *
     * @var array
     */
    protected $dontReport = [
        NotFoundException::class,
        InvalidDataException::class,
        InvalidRegisterVerificationTokenException::class,
        HasAlreadyBeenVerifiedException::class,
        UnauthorizedActionException::class,
        UnauthenticatedException::class,
        EmailOrPasswordInvalidException::class
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                throw new NotFoundException;
            }
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*')) {
                throw new UnauthorizedActionException();
            }
        });
    }
}