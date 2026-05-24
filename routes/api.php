<?php

use App\Http\Controllers\Api\V1\BusinessController;
use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\TrackingController;
use App\Http\Middleware\ValidateClientApiKey;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/track', [TrackingController::class, 'track'])
        ->middleware(['throttle:tracking', ValidateClientApiKey::class]);

    Route::post('/businesses/register', [BusinessController::class, 'register'])
        ->middleware('throttle:api');

    Route::get('/industries', [BusinessController::class, 'industries'])
        ->middleware('throttle:api');

    Route::get('/status', [StatusController::class, 'index'])
        ->middleware('throttle:api');
});
