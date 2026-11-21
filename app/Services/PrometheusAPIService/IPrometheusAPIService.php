<?php

namespace App\Services\PrometheusAPIService;

interface IPrometheusAPIService
{
    public function sendGraphQLRequest(string $query, ?array $variables = null): array;
}
