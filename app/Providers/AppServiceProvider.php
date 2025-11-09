<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Sanctum\PersonalAccessToken;
use App\Services\Contracts\EmailService;
use App\Services\Contracts\ResponseService;
use App\Services\EmailManagementService;
use App\Services\JsonResponseService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        $this->app->bind(EmailService::class, EmailManagementService::class);
        $this->app->bind(ResponseService::class, JsonResponseService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        RateLimiter::for('login', fn () => Limit::perMinutes(2, 3)->by(request()->input('email')));
    }
}
