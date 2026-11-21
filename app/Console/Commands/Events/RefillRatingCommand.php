<?php

namespace App\Console\Commands\Events;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\Rating;
use App\Services\EventsService;
use Illuminate\Console\Command;

class RefillRatingCommand extends Command
{
    protected $signature = 'events:refill-rating';

    protected $description = 'Command description';

    public function handle(): void
    {
        $events = Event::whereIn('status', [
            EventStatus::IN_REPORTING,
            EventStatus::IN_REPORT_REVISION,
            EventStatus::IN_REPORT_AGREEMENT,
            EventStatus::IN_REPORT_PUBLISHED,
            EventStatus::ARCHIVED,
        ])->get();

        foreach ($events as $event) {
            if (Rating::whereEventId($event->id)->doesntExist()) {
                $eventsService = app(EventsService::class);
                $users = collect()
                    ->merge($event->coauthors()->pluck('user_id')->toArray())
                    ->merge($event->members()->pluck('user_id')->toArray());

                foreach ($users as $user) {
                    $data = $eventsService->calculateUserPoints($event, $user);
                    if (is_null($data)) {
                        continue;
                    }
                    $eventsService->addRatingPoints($event, $user, $data['points'], $data['role']);
                }
            }
        }
    }
}
