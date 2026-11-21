<?php

namespace App\Http\Controllers\API;

use App\Enums\EventStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnnouncementResource;
use App\Models\Event;

class AnnouncementsController extends Controller
{
    public function index()
    {
        return AnnouncementResource::collection(
            Event::where('announcement_enabled', true)
                ->where('status', EventStatus::PUBLISHED)
                ->where('dates_start_date', '>=', now()->startOfDay())
                ->orderBy('dates_start_date')
                ->orderBy('dates_start_time')
                ->cursorPaginate()
        );
    }

    public function show(Event $event)
    {
        abort_unless($event->announcement_enabled && $event->status === EventStatus::PUBLISHED, 404);

        return AnnouncementResource::make($event)->resolve();
    }

    public function register(Event $event)
    {
        abort_unless(
            $event->is_registration_available,
            418,
            'Регистрация на данное мероприятие недоступна',
        );

        $event->members()
            ->updateOrCreate(['user_id' => auth()->id()]);

        return response()->json(['status' => 'success'], 200);
    }
}
