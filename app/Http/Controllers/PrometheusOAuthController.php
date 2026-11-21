<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;

class PrometheusOAuthController extends Controller
{
    public function redirect()
    {
        if (config('services.prometheus.debug', false)) {
            $user = User::updateOrCreate(['email' => 'naggadim@dev'], [
                'last_name' => 'Смертин',
                'first_name' => 'Дмитрий',
                'patronymic' => 'Анатольевич',
                'password' => 'password',
            ]);

            auth()->login($user, remember: true);

            return redirect()->route('announcements.index');
        }

        return Socialite::driver('prometheus')->redirect();
    }

    public function callback()
    {
        /** @var \SocialiteProviders\Manager\OAuth2\User $prometheusUser */
        $prometheusUser = Socialite::driver('prometheus')->user();
        $user = User::fromOAuthPrometheus($prometheusUser);

        Auth::login($user);

        return redirect()
            ->route('announcements.index');
    }
}
