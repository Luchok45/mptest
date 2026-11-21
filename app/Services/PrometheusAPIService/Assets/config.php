<?php

return [
    'host' => 'https://lk.nngasu.ru',
    'client_id' => env('PROMETHEUS_API_CLIENT_ID'),
    'client_secret' => env('PROMETHEUS_API_CLIENT_SECRET'),
    'cache' => [
        'access_token' => [
            'lifetime' => 60 * 24 * 7, // 7 days
            'key' => 'prometheus_api_access_token',
        ],
        'refresh_token' => [
            'lifetime' => 60 * 24 * 30, // 30 days
            'key' => 'prometheus_api_refresh_token',
        ],
    ],
];
