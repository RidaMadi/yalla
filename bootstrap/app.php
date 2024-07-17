<?php

use App\ApiCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: '/api',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Apply middleware to all routes
//        $middleware->use([ExampleMiddleware::class]);
        $middleware->alias([
            'checkAuth' => \App\Http\Middleware\CheckAuth::class,
        ]);
        // Use it only in the web routes
//        $middleware->web([ExampleMiddleware::class]);

        // API only
//        $middleware->api([ExampleMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return Response::json([
                    'status' => ApiCode::UNAUTHORIZED,
                    'errorCode' => 1,
                    'data' => null,
                    'message' => __('You are not authorized'),
                ], ApiCode::UNAUTHORIZED);
            }
        });

        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return Response::json([
                    'status' => ApiCode::NOT_FOUND,
                    'errorCode' => 1,
                    'data' => null,
                    'message' => __('Model not found!'),
                ], ApiCode::NOT_FOUND);
            }
        });

        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return Response::json([
                    'status' => ApiCode::BAD_REQUEST,
                    'errorCode' => 1,
                    'data' => $e->validator->errors(),
                    'message' => "validation error!",
                ], ApiCode::BAD_REQUEST);
            }
        });

        $exceptions->render(function (TokenInvalidException $e, Request $request) {
            if ($request->is('api/*')) {
                return response([
                    "status" => ApiCode::UNAUTHORIZED,
                    "errorCode" => 1,
                    "data" => null,
                    "message" => "token is invalid"
                ],ApiCode::UNAUTHORIZED);
            }
        });


        $exceptions->render(function (TokenExpiredException $e, Request $request) {
            if ($request->is('api/*')) {
                return response([
                    "status" => ApiCode::UNAUTHORIZED,
                    "errorCode" => 1,
                    "data" => null,
                    "message" => "token is expired"
                ],ApiCode::UNAUTHORIZED);
            }
        });

        $exceptions->render(function (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException $e, Request $request) {
            if ($request->is('api/*')) {
                return response([
                    "status" => ApiCode::UNAUTHORIZED,
                    "errorCode" => 1,
                    "data" => null,
                    "message" => "token in blacklisted"
                ],ApiCode::UNAUTHORIZED);
            }
        });

        $exceptions->render(function (JWTException  $e, Request $request) {
            if ($request->is('api/*')) {
                return response([
                    "status" => ApiCode::UNAUTHORIZED,
                    "errorCode" => 1,
                    "data" => null,
                    "message" => "there is problem with token"
                ],ApiCode::UNAUTHORIZED);
            }
        });


        $exceptions->render(function (Error $e, Request $request) {
            if ($request->is('api/*')) {
                return Response::json([
                    'status' => ApiCode::INTERNAL_SERVER_ERROR,
                    'errorCode' => 1,
                    'data' => null,
                    'message' => __('internal server error'),
                ], ApiCode::INTERNAL_SERVER_ERROR);
            }
        });

        // Handle all other exceptions as internal server errors
        $exceptions->render(function (Exception $e, Request $request) {
            if ($request->is('api/*')) {
                return Response::json([
                    'status' => ApiCode::INTERNAL_SERVER_ERROR,
                    'errorCode' => 1,
                    'data' => null,
                    'message' => __('internal server error'),
                ], ApiCode::INTERNAL_SERVER_ERROR);
            }
        });
    })
    ->create();
