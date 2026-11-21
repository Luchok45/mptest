<?php

use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;
use App\Services\PrometheusAPIService\Providers\PrometheusAPIServiceProvider;

return [
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    PrometheusAPIServiceProvider::class,
];
