<?php

use App\Enums\HttpStatusEnum;
use App\Services\JsonResponseService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo('/login');
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->shouldRenderJsonWhen(function (Request $request) {
            return $request->is('api/*') || $request->expectsJson();
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return JsonResponseService::processResponse(
                    message: 'Unauthorized Request! missing or invalid Bearer token.',
                    httpStatusEnum: HttpStatusEnum::UNAUTHORIZED
                );
            }
        });

        $exceptions->render(function (ValidationException $validationException, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return JsonResponseService::processResponse(
                    message: $validationException->errors(),
                    httpStatusEnum: HttpStatusEnum::UNPROCESSABLE_ENTITY
                );
            }
        });

        $exceptions->render(function (Throwable $throwable, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return JsonResponseService::processResponse(
                    message: $throwable->getMessage(),
                    httpStatusEnum: HttpStatusEnum::INTERNAL_SERVER_ERROR
                );
            }
        });
    })->create();
