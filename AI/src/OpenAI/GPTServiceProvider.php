<?php

namespace AIGenerate\Services\AI\OpenAI;

use Illuminate\Support\ServiceProvider;
use AIGenerate\Models\OpenAI\OpenAiKey;
use AIGenerate\Models\OpenAI\OpenAiKeyStack;
use AIGenerate\Services\AI\OpenAI\Repositories\OpenAiKeyRepository;

class GPTServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Images\ApiService::class, fn() => new Images\ApiService());
        $this->app->singleton(Chat\ApiService::class, fn() => new Chat\ApiService());
        $this->app->singleton(Completion\ApiService::class, fn() => new Completion\ApiService());

        $this->app->singleton(
            OpenAiKeyRepository::class,
            fn() => new OpenAiKeyRepository(OpenAIKey::class, OpenAiKeyStack::class)
        );

        $this->app->singleton(Chat\ApiRecursiveService::class, fn($app) => new Chat\ApiRecursiveService(
            $app->make(OpenAiKeyRepository::class)
        ));
    }
}
