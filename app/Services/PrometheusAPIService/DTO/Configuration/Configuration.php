<?php

namespace App\Services\PrometheusAPIService\DTO\Configuration;

readonly class Configuration
{
    public APIConfiguration $api;

    public CacheConfiguration $cache;

    public function __construct()
    {
        $config = config('services.prometheus-api');

        $this->api = new APIConfiguration(
            $config['host'],
            $config['client_id'],
            $config['client_secret']
        );
        $this->cache = new CacheConfiguration(
            $config['cache']['access_token']['key'],
        );
    }
}
