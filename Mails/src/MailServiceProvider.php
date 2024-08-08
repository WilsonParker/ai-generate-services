<?php

namespace AIGenerate\Services\Mails;

use Illuminate\Support\ServiceProvider;
use AIGenerate\Services\Mails\Brevo\BrevoService;
use AIGenerate\Services\Mails\Composites\Parameters\BestPromptParameters;
use AIGenerate\Services\Mails\Composites\Parameters\UserParameters;
use AIGenerate\Services\Mails\Contracts\MailContract;
use AIGenerate\Services\Mails\Contracts\PromptServiceContract;

class MailServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            BestPromptParameters::class,
            fn($app) => new BestPromptParameters($app->make(PromptServiceContract::class))
        );
        $this->app->singleton(
            UserParameters::class,
            fn() => new UserParameters()
        );
        $this->app->singleton(MaiParameterComposite::class,
            fn() => new MaiParameterComposite([
                $this->app->make(UserParameters::class),
                $this->app->make(BestPromptParameters::class),
            ])
        );

        $this->app->singleton(
            BrevoService::class,
            fn($app) => new BrevoService(
                config('brevo.api_key'),
                $app->make(MaiParameterComposite::class)
            )
        );

        $this->app->bind(
            MailContract::class,
            BrevoService::class
        );
    }

}
