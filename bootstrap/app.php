<?php

use App\Http\Middleware\SetlocaleMiddleware;
use Illuminate\Support\Str;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
             'language' => SetlocaleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if (request()->is('api/*') && $e->getPrevious() instanceof ModelNotFoundException) {
                $model = Str::afterLast($e->getPrevious()->getModel(), '\\');
                return response()->json(['message' => $model . __('messages.notfound')], 404);
            }
            return response()->json(['message' => __('messages.error')], 404);
        });

    })->create();
