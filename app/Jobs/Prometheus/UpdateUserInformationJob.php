<?php

namespace App\Jobs\Prometheus;

use App\Models\User;
use App\Services\PrometheusAPIService\PrometheusAPI;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateUserInformationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected User $user) {}

    public function handle(): void
    {
        if (empty($this->user) || empty($this->user->oauth_prometheus_id)) {
            return;
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
            ['id' => $this->user->oauth_prometheus_id]
        )['data']['user'];

        $email = $userInfo['contactInformation']['email'] ?? $userInfo['email'];

        $this->user->update([
            'email' => $email,
            'last_name' => $userInfo['last_name'],
            'first_name' => $userInfo['first_name'],
            'patronymic' => $userInfo['patronymic'],
            'birthdate' => $userInfo['birthdate'],
            'avatar' => $userInfo['avatar'] ? "https://lk.nngasu.ru/profile/{$this->user->oauth_prometheus_id}/avatar" : null,
        ]);
    }
}
