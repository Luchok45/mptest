<?php

namespace App\Services\PrometheusAPIService\DTO\Configuration;

readonly class APIConfiguration
{
    public function __construct(
        public ?string $host = null,
        public ?string $oauthClientID = null,
        public ?string $oauthClientSecret = null,
    ) {}
}
