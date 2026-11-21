<?php

namespace App\Services\PrometheusAPIService\DTO\Configuration;

readonly class CacheConfiguration
{
    public function __construct(
        public ?string $oauthAccessTokenKey = null,
    ) {}
}
