<?php

namespace App\Providers;

use App\OAuth\Providers\PrometheusProvider;
use App\Services\FilePreloadService\FilePreloadServiceInterface;
use App\Services\FilePreloadService\StoragePreloadService;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Laravel\Passport\Passport;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FilePreloadServiceInterface::class, StoragePreloadService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole() && config('app.force_https', false)) {
            URL::forceScheme('https');
        }

        $this->configureDefaults();
        $this->configurePassport();

        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('prometheus', PrometheusProvider::class);
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    protected function configurePassport(): void
    {
        Passport::tokensExpireIn(CarbonInterval::month());
        Passport::refreshTokensExpireIn(CarbonInterval::months(2));
        Passport::personalAccessTokensExpireIn(CarbonInterval::year());

        Passport::deviceUserCodeView(
            fn ($parameters) => Inertia::render('auth/oauth/device/UserCode')
        );

        Passport::deviceAuthorizationView(
            fn ($parameters) => Inertia::render('auth/oauth/device/Authorize', [
                'request' => $parameters['request'],
                'authToken' => $parameters['authToken'],
                'client' => $parameters['client'],
                'user' => $parameters['user'],
                'scopes' => $parameters['scopes'],
            ])
        );
    }
}
