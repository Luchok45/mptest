<?php

namespace App\OAuth\Providers;

use SocialiteProviders\LaravelPassport\Provider;

class PrometheusProvider extends Provider
{
    public const string IDENTIFIER = 'prometheus';
}
