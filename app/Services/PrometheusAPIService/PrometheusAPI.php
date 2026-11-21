<?php

namespace App\Services\PrometheusAPIService;

use Illuminate\Support\Facades\Facade;

/**
 * @see IPrometheusAPIService
 * @see PrometheusAPIService
 *
 * @method static array sendGraphQLRequest(string $query, null|array $variables = null)
 */
class PrometheusAPI extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return IPrometheusAPIService::class;
    }
}
