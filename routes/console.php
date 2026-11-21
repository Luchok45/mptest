<?php

use App\Enums\EventStatus;
use App\Jobs\UpdateEventsStatusJob;
use App\Models\Event;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(UpdateEventsStatusJob::class, connection: 'sync')->everyMinute();
