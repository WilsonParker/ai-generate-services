<?php

namespace AIGenerate\Services\Brevo;

use Brevo\Client\Api\ContactsApi;
use Brevo\Client\Configuration;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use AIGenerate\Services\Brevo\Contracts\BrevoContract;

class BrevoServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $client = new ContactsApi(
            new Client(),
            Configuration::getDefaultConfiguration()->setApiKey('api-key', config('brevo.api_key'))
        );

        $this->app->singleton(
            BrevoService::class,
            fn($app) => new BrevoService($client)
        );

        $this->app->singleton(
            BrevoEnterpriseRequestService::class,
            fn($app) => new BrevoEnterpriseRequestService($client)
        );

        $this->app->bind(
            BrevoContract::class,
            BrevoService::class
        );
    }

}
