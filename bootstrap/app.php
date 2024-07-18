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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'administrator' => \App\Http\Middleware\Administrator::class,
            'gudang' => \App\Http\Middleware\Gudang::class,
            'pembelian' => \App\Http\Middleware\Pembelian::class,
            'produksi' => \App\Http\Middleware\Produksi::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
