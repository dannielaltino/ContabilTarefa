<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectUsersTo(function (Request $request) {
            if (auth()->guard('contabil')->check()) {
                return route('home_contabil');
            }
    
            if (auth()->guard('cliente')->check()) {
                return route('home_cliente');
            }
    
            return route('login');
        });
        
        // $middleware->alias([
        //     'guest' => RedirectIfAuthenticated::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
