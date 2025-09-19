<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'otp.verified' => \App\Http\Middleware\EnsureOtpVerified::class,
            'otp.redirect' => \App\Http\Middleware\RedirectIfOtpVerified::class,
        ]);
    })
    ->withCommands([
        App\Console\Commands\SendReminders::class,
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
