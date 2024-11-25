<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\SelectAuthMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Middleware\RoleMiddleware;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'selectAuthMiddleware' => SelectAuthMiddleware::class,
        ]);

        $middleware->trustProxies(headers: Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        $exceptions->render(function (ModelNotFoundException $e) {
            $apiResponseHelper = new \App\Helpers\ApiResponseHelper();

            return $apiResponseHelper->notFoundResponse();
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            $apiResponseHelper = new \App\Helpers\ApiResponseHelper();

            return $apiResponseHelper->notFoundResponse();
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e) {
            $apiResponseHelper = new \App\Helpers\ApiResponseHelper();

            return $apiResponseHelper->methodNotAllowedResponse();
        });

        $exceptions->render(function (AuthenticationException $e) {
            $apiResponseHelper = new \App\Helpers\ApiResponseHelper();

            return $apiResponseHelper->unauthorizedResponse();
        });

        $exceptions->render(function (ValidationException $e) {
            $apiResponseHelper = new \App\Helpers\ApiResponseHelper();

            return $apiResponseHelper->badRequestResponse([
                'errors' => $e->errors(),
            ]);
        });

        $exceptions->render(function (Exception $e) {
            $apiResponseHelper = new \App\Helpers\ApiResponseHelper();

            $exception = [
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
            ];

            if (config('app.debug')) {
                $exception['debug'] = [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                    'trace'   => $e->getTrace(),
                ];
            }

            return $apiResponseHelper->internalErrorResponse(data: [
                'exception' => $exception,
            ]);
        });
    })->create();
