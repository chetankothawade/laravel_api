<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
//USE FOR Rate Limiting MIDDLEWARE
use App\Http\Middleware\RateLimitByRole;
use App\Http\Middleware\RateLimitByIP;
use App\Http\Middleware\BurstLimit;
use App\Http\Middleware\RateLimitByToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Enable CORS globally
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
        //USE FOR Rate Limiting MIDDLEWARE
        $middleware->alias([
            'role.throttle' => RateLimitByRole::class,
            'ip.throttle' => RateLimitByIP::class,
            'burst.throttle' => BurstLimit::class,
            'token.throttle' => RateLimitByToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, $request) {
            if (! $request->expectsJson()) {
                return null;
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'status' => false,
                    'message' => __('messages.validation_failed'),
                    'errors' => $e->errors(),
                    'code' => 422,
                ], 422);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'status' => false,
                    'message' => __('messages.unauthenticated'),
                    'code' => 401,
                ], 401);
            }

            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'status' => false,
                    'message' => __('messages.record_not_found'),
                    'code' => 404,
                ], 404);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => false,
                    'message' => __('messages.endpoint_not_found'),
                    'code' => 404,
                ], 404);
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'status' => false,
                    'message' => __('messages.method_not_allowed'),
                    'code' => 405,
                ], 405);
            }

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode() ?: 500,
            ], 500);
        });
    })
    ->create();
