<?php

namespace App\Models;

use App\Services\PrometheusAPIService\PrometheusAPI;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['last_name', 'first_name', 'patronymic', 'avatar', 'email', 'birthdate', 'phone', 'password', 'oauth_prometheus_id', 'oauth_prometheus_token', 'oauth_prometheus_refresh_token'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements OAuthenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable, TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'birthdate' => 'date',
        ];
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            get: function (?string $value) {
                if (preg_match('/^(\d{3})(\d{3})(\d{2})(\d{2})$/', $value ?? '', $matches)) {
                    return "+7 ({$matches[1]}) {$matches[2]}-{$matches[3]}-{$matches[4]}";
                }

                return null;
            },

            set: function (string $value) {
                return mb_substr(preg_replace('/[^0-9]/', '', $value), -10);
            }
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => str($this->last_name)
                ->lower()
                ->trim()
                ->ucfirst()
                ->append(' '.str($this->first_name)->trim()->upper()->substr(0, 1).'.')
                ->when(! empty($this->patronymic), fn ($str) => $str->append(str($this->patronymic)->trim()->upper()->substr(0, 1).'.'))
                ->toString()
        );
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => str('')
                ->append(str($this->last_name)->trim()->lower()->ucfirst())
                ->append(' ')
                ->append(str($this->first_name)->trim()->lower()->ucfirst())
                ->append(' ')
                ->append(str($this->patronymic)->trim()->lower()->ucfirst())
                ->trim()
                ->toString()
        );
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value = null) => $value ?? '/assets/images/defaultAvatar.png'
        );
    }

    public static function fromOAuthPrometheus(\SocialiteProviders\Manager\OAuth2\User $socialiteUser): User
    {
        $user = User::whereOauthPrometheusId($socialiteUser->id)->first();
        if (! empty($user)) {
            return $user;
        }

        $userInfo = PrometheusAPI::sendGraphQLRequest(
            '
                query GetUserInfo($id: ID!) {
                    user(id: $id) {
                        contactInformation {
                            email
                        }
                        email
                        last_name
                        first_name
                        patronymic
                        birthdate
                        avatar
                    }
                }
            ',
            ['id' => $socialiteUser->id]
        )['data']['user'];

        $email = $userInfo['contactInformation']['email'] ?? $userInfo['email'];

        return User::create([
            'oauth_prometheus_id' => $socialiteUser->id,
            'email' => $email,
            'last_name' => $userInfo['last_name'],
            'first_name' => $userInfo['first_name'],
            'patronymic' => $userInfo['patronymic'],
            'password' => Str::password(),
            'birthdate' => $userInfo['birthdate'],
            'avatar' => $userInfo['avatar'] ? "https://lk.nngasu.ru/profile/{$socialiteUser->id}/avatar" : null,
        ]);
    }
}
