<?php

namespace App\Jobs;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Services\EventsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateEventsStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected EventsService $eventsService) {}

    public function handle(): void
    {
        $nextPageCursor = null;
        do {
            $items = Event::whereStatus(EventStatus::PUBLISHED)
                ->where(function ($query) {
                    return $query->whereNotNull('dates_end_date')
                        ->where('dates_end_date', '<', now()->endOfDay());
                })
                ->orWhere(function ($query) {
                    return $query->whereNull('dates_end_date')
                        ->where('dates_start_date', '<', now()->endOfDay());
                })
                ->cursorPaginate(perPage: 10, cursor: $nextPageCursor);

            $nextPageCursor = $items->nextCursor();

            foreach ($items as $item) {
                $this->eventsService->goToReporting($item);
            }
        } while (! empty($nextPageCursor));
    }
}
