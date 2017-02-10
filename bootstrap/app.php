<?php

require_once __DIR__ . "/../vendor/autoload.php";

try {
    (new Dotenv\Dotenv(__DIR__ . "/../"))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //.end file was not found
    //does nothing
}

$app = new Laravel\Lumen\Application(realpath(__DIR__ . "/../"));
$app->withFacades();
$app->withEloquent();

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->group(["namespace" => 'App\Http\Controllers'], function ($app) {
    require __DIR__ . "/../routes/web.php";
});

return $app;