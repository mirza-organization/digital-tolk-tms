<?php

declare(strict_types=1);

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\TranslationController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn (): string => 'Welcome to the LARAVEL APi!');

Route::controller(AuthenticationController::class)->group(function (): void {
    Route::get('/login', 'login')->middleware('throttle:login');
});

Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::prefix('translations')->controller(TranslationController::class)->group(function (): void {
        Route::get('/view', 'index');
        Route::post('/create', 'store');
        Route::patch('/update', 'update');
        Route::get('/search', 'search');
    });
});
