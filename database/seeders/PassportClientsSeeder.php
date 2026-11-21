<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;

class PassportClientsSeeder extends Seeder
{
    public function __construct(protected ClientRepository $repository) {}

    public function run(): void
    {
        if (Client::where('name', 'Мобильное приложение')->doesntExist()) {
            $client = app(ClientRepository::class)->createDeviceAuthorizationGrantClient(
                name: 'Мобильное приложение',
            );

            echo "Мобильное приложение:\n\tclient_id: {$client->id}\n\tclient_secret: {$client->plain_secret}\n";
        }
    }
}
