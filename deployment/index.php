<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 * 
 * CPANEL DEPLOYMENT INDEX FILE
 * ============================
 * Upload this file to your public_html folder
 * Make sure to update the path below to match your setup
 */

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Configure Laravel App Path
|--------------------------------------------------------------------------
| Change 'laravel-app' to match your Laravel installation folder name
| This should be the folder OUTSIDE of public_html where Laravel is installed
|
| Example paths:
| - ../laravel-app (if Laravel is in /home/username/laravel-app)
| - ../airline-ticket-system (if that's your folder name)
|
*/
$laravelPath = __DIR__ . '/laravel-app';

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
*/
if (file_exists($maintenance = $laravelPath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/
require $laravelPath . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/
$app = require_once $laravelPath . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
