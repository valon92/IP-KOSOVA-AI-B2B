<?php

use App\Http\Controllers\Api\V1\BusinessController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\ClientAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('guest:client')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');
});

Route::middleware('auth:client')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [ClientAuthController::class, 'logout'])->name('logout');

    // Dashboard API — web middleware (session) so auth works reliably with the SPA
    Route::prefix('api/v1')->middleware('throttle:api')->group(function () {
        Route::get('/auth/me', [ClientAuthController::class, 'me']);

        Route::get('/dashboard/metrics', [DashboardController::class, 'metrics']);
        Route::get('/dashboard/live-feed', [DashboardController::class, 'liveFeed']);
        Route::get('/dashboard/business-leads', [DashboardController::class, 'businessLeads']);
        Route::get('/dashboard/companies', [DashboardController::class, 'companies']);

        Route::get('/businesses', [BusinessController::class, 'index']);
        Route::get('/businesses/{business}/detail', [BusinessController::class, 'detail']);
        Route::get('/businesses/{business}', [BusinessController::class, 'show']);
    });
});

Route::get('/status', function () {
    return view('status');
});

Route::get('/dpa', function () {
    return view('dpa');
});

Route::get('/kushtet', function () {
    return view('kushtet');
});

Route::get('/privatesia', function () {
    return view('privatesia');
});

Route::get('/info', function () {
    return view('info');
});

Route::get('/register-business', function () {
    return view('register-business');
});

Route::post('/login', [ClientAuthController::class, 'login'])->middleware('guest:client');
