<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /**
         * Ici, on désactive la protection CSRF uniquement pour les routes
         * d'authentification Fortify, afin de pouvoir les appeler facilement
         * depuis Postman sans avoir à gérer manuellement le token CSRF.
         *
         * Les autres routes continuent d'être protégées par CSRF.
         */
        $middleware->validateCsrfTokens(
            except: [
                'login',
                'register',
                'logout',
                'forgot-password',
                'reset-password',
            ],
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
