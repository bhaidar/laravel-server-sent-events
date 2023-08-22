<?php

declare(strict_types=1);

namespace App\Providers;

use OpenAI;
use OpenAI\Client;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;


class OpenAIServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, static function (): Client {
            $apiKey = config('services.openai.api_key');
            $organization = config('services.openai.organization');

            return OpenAI::factory()
                ->withHttpClient(new \GuzzleHttp\Client(['timeout' => intval(config('services.openai.timeout'))]))
                ->withApiKey($apiKey)
                ->withOrganization($organization)
                ->make();
        });

        $this->app->alias(Client::class, 'openai');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            Client::class,
        ];
    }
}
