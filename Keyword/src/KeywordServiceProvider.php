<?php

namespace AIGenerate\Services\Keyword;

use Illuminate\Support\ServiceProvider;

class KeywordServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/word_filter.php' => config_path('word_filter.php'),
        ], 'config');
    }

    public function register(): void
    {
        $this->app->singleton(
            KeywordFilterService::class,
            fn($app) => new KeywordFilterService(),
        );
    }
}
