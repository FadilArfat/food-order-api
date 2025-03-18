<?php

use App\Http\Middleware\AbleCreateOrder;
use App\Http\Middleware\AbleCreateUpdateItem;
use App\Http\Middleware\AbleCreateUser;
use App\Http\Middleware\AbleFinishOrder;
use App\Http\Middleware\AblePayOrder;
use App\Http\Middleware\AbleSeeOrderReport;
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
    ->withMiddleware(function (Middleware $middleware) {
         $middleware->alias([
        'ableCreateOrder' => AbleCreateOrder::class,
        'ableFinishOrder' => AbleFinishOrder::class,
            'ableCreateUser' => AbleCreateUser::class,
            'ableCreateUpdateItem' => AbleCreateUpdateItem::class,
            'ablePayOrder' => AblePayOrder::class,
            'ableSeeOrderReport' => AbleSeeOrderReport::class


    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
