<?php

declare(strict_types=1);

namespace Magadanuhak\ProvablyFair;

use Illuminate\Support\ServiceProvider;
use Magadanuhak\ProvablyFair\Contracts\ProvablyFairContract;
use Magadanuhak\ProvablyFair\Services\ProvablyFair;

class ProvablyFairServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProvablyFairContract::class, ProvablyFair::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
