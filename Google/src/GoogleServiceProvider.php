<?php

namespace AIGenerate\Services\Google;

use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SafeSearchApiService::class, function () {
            return new SafeSearchApiService();
        });
    }

    public function boot(): void
    {
    }
}
