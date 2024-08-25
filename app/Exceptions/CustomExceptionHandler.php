<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class CustomExceptionHandler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->view('partials.error', ['code' => 404, 'message' => 'Resource not found']);
        }

        if ($exception instanceof ValidationException) {
            return response()->view('partials.error', ['code' => 422, 'message' => 'Validation error']);
        }

        if ($exception instanceof HttpException) {
            return response()->view('partials.error', ['code' => $exception->getStatusCode(), 'message' => $exception->getMessage()]);
        }

        if ($exception instanceof AuthenticationException) {
            return parent::render($request, $exception);
        }

        return response()->view('partials.error', ['code' => 500, 'message' => 'Server error']);
    }
}
