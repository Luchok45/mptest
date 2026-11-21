<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Http\Resources\Events\FullResource;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AnnouncementsController extends Controller
{
    public function index()
    {
        $validator = Validator::make(request()->input(), [
            'date' => 'nullable|numeric|min:0|max:4102444800000',
            'search' => 'nullable|string|max:255',
        ]);

        abort_if($validator->fails(), 400, $validator->errors()->first());

        $search = $validator->safe()->input('search');
        $date = $validator->safe()->input('date');

        if (! empty($date)) {
            $dates = [Carbon::createFromTimestamp($date / 1000, timezone: 'Europe/Moscow')];
        } else {
            $dates = Event::whereStatus(EventStatus::PUBLISHED)
                ->select(['dates_start_date'])
                ->groupBy('dates_start_date')
                ->pluck('dates_start_date');
        }

        $announcements = [];
        foreach ($dates as /** @var Carbon $date */ $date) {
            if (
                Event::whereStatus(EventStatus::PUBLISHED)
                    ->where('dates_start_date', '>=', $date->clone()->startOfDay())
                    ->where('dates_start_date', '<=', $date->clone()->endOfDay())
                    ->when(! empty($search), fn ($query) => $query->where('main_name', 'like', '%'.$search.'%'))
                    ->doesntExist()
            ) {
                continue;
            }

            $announcements[$date->toIso8601String()] = FullResource::collection(
                Event::whereStatus(EventStatus::PUBLISHED)
                    ->where('dates_start_date', '>=', $date->clone()->startOfDay())
                    ->where('dates_start_date', '<=', $date->clone()->endOfDay())
                    ->when(! empty($search), fn ($query) => $query->where('main_name', 'like', '%'.$search.'%'))
                    ->get()
            )->resolve();
        }

        return inertia('announcements/Index', [
            'announcements' => $announcements,
        ]);
    }

    public function show(Event $event)
    {
        return inertia('announcements/Show', [
            'event' => FullResource::make($event)->resolve(),
            'registryAvailable' => $event->registration_enabled && now() < $event->registration_end_date->endOfDay() && (
                $event->registration_members_count <= 0
                    || $event->registration_members_count > $event->members()->count()
            ),
            'meRegistered' => $event->members()->whereUserId(auth()->id())->exists(),
        ]);
    }

    public function register(Event $event)
    {
        $event->members()
            ->updateOrCreate(['user_id' => auth()->id()]);
    }
}
