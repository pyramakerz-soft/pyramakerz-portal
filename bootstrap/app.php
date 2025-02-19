<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register the 'student.auth' middleware alias
        $middleware->alias([
            'student.auth' => \App\Http\Middleware\StudentAuth::class,
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class
        ]);

        // Optionally, you can append the middleware to a group if needed
        // For example, to add it to the 'web' middleware group:
        // $middleware->appendToGroup('web', \App\Http\Middleware\StudentAuth::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Exception handling configuration
    })
    ->create();
