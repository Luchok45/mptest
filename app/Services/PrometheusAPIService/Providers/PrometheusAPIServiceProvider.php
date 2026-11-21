<?php

namespace App\Services\PrometheusAPIService\Providers;

use App\Services\PrometheusAPIService\IPrometheusAPIService;
use App\Services\PrometheusAPIService\PrometheusAPIService;
use Illuminate\Support\ServiceProvider;

class PrometheusAPIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Assets/config.php', 'services.prometheus-api');
        $this->app->bind(IPrometheusAPIService::class, PrometheusAPIService::class);
    }

    public function boot(): void {}
}
