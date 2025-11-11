<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Contracts\ResponseService;
use App\Services\JsonResponseService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        $this->app->bind(ResponseService::class, JsonResponseService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', fn () => Limit::perMinutes(2, 5)->by(request()->input('email')));
    }
}
