<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ExceptionResponseTrait;
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
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $exception) {
            if ($exception instanceof NotFoundHttpException) {
                return $this->errorResponse(
                    __('errors.not_found'),
                    $exception->getStatusCode() !== 0 ? $exception->getStatusCode() : Response::HTTP_NOT_FOUND,
                    $exception->getTrace()
                );
            }

            if ($exception instanceof ValidationException) {
                return $this->errorResponse(
                    $exception->getMessage(),
                    $exception->status,
                    $exception->getTrace()
                );
            }

            return $this->errorResponse(
                $exception->getMessage(),
                $exception->getCode() !== 0 ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR,
                $exception->getTrace()
            );
        });
    }
}
