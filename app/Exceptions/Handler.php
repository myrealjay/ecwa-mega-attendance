<?php

namespace App\Exceptions;

use App\Traits\HasResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;
use Exception;

class Handler extends ExceptionHandler
{
    use HasResponse;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

     /**
     * Handles all throwable exceptions
     *
     * @param $request
     * @param \Throwable $e
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->notAllowedResponse(__('errors.method_not_allowed'));
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->notFoundResponse($e->getMessage() ? $e->getMessage() : __('errors.not_found'));
        }

        if ($e instanceof ValidationException) {
            return $this->formValidationResponse(__('errors.validation_failed'), $e->errors());
        }

        if ($e instanceof AuthenticationException) {
            return $this->notAuthenticated($e->getMessage());
        }

        if ($e instanceof AuthorizationException) {
            return $this->notAllowedResponse($e->getMessage());
        }

        if ($e instanceof RouteNotFoundException) {
            return $this->notFoundResponse($e->getMessage());
        }

        if ($e instanceof UnauthorizedException) {
            return $this->notAllowedResponse($e->getMessage());
        }

        return $this->serverErrorResponse(__('errors.server_error'), new Exception($e->getMessage()));
    }
}
