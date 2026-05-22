<?php

use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\TrackingController;
use App\Http\Middleware\ValidateClientApiKey;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/track', [TrackingController::class, 'track'])
        ->middleware(['throttle:tracking', ValidateClientApiKey::class]);

    Route::middleware([ValidateClientApiKey::class, 'throttle:api'])->group(function () {
        Route::get('/dashboard/metrics', [DashboardController::class, 'metrics']);
        Route::get('/dashboard/live-feed', [DashboardController::class, 'liveFeed']);
        Route::get('/dashboard/companies', [DashboardController::class, 'companies']);
    });
});
