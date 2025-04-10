<?php

use App\Http\Middleware\AlwaysAcceptJson;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->group(base_path('routes/api_v1.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prependToGroup('api', AlwaysAcceptJson::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'errors' => 'Endpoint not found',
                        'status' => Response::HTTP_NOT_FOUND
                        ], Response::HTTP_NOT_FOUND);
                }
                if ($e instanceof MethodNotAllowedHttpException) {
                    return response()->json([
                        'errors' => 'Method not allowed',
                        'status' => Response::HTTP_METHOD_NOT_ALLOWED
                        ], Response::HTTP_METHOD_NOT_ALLOWED);
                }
            }
        });
    })->create();
