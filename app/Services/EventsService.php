<?php

namespace App\Services;

use App\Enums\EventLevel;
use App\Enums\EventStatus;
use App\Enums\RewardType;
use App\Models\Balance;
use App\Models\Event;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EventsService
{
    public function goToReporting(int|Event $event): void
    {
        $event = is_int($event) ? Event::findOrFail($event) : $event->id;

        DB::transaction(function () use ($event) {
            $event->update(['status' => EventStatus::IN_REPORTING]);
            $users = collect()
                ->merge($event->coauthors()->pluck('user_id')->toArray())
                ->merge($event->members()->pluck('user_id')->toArray());

            foreach ($users as $user) {
                $data = $this->calculateUserPoints($event, $user);
                if (is_null($data)) {
                    continue;
                }
                $this->addRatingPoints($event, $user, $data['points'], $data['role']);
            }
        });
    }

    public function assignUserToEvent(int|Event $event, int|User $user): void
    {
        $userID = is_int($user) ? $user : $user->id;
        $event = is_int($event) ? Event::findOrFail($event) : $event;

        $event->members()->updateOrCreate(['user_id' => $userID]);
    }

    public function unassignUserFromEvent(int|Event $event, int|User $user): void
    {
        $userID = is_int($user) ? $user : $user->id;
        $event = is_int($event) ? Event::findOrFail($event) : $event;

        $event->members()->where('user_id', $userID)->delete();
    }

    public function addRatingPoints(int|Event $event, int|User $user, int $modification, ?string $role = null): void
    {
        $userID = is_int($user) ? $user : $user->id;
        $eventID = is_int($event) ? $event : $event->id;
        Cache::lock("rating-event-$eventID-user-$userID", 60)->block(55, function () use ($eventID, $userID, $modification, $role) {
            if (Rating::where('event_id', $eventID)->where('user_id', $userID)->exists()) {
                return;
            }

            DB::transaction(function () use ($eventID, $userID, $modification, $role) {
                Rating::updateOrCreate(['user_id' => $userID, 'event_id' => $eventID], ['modification' => $modification, 'role' => $role]);
                Balance::create(['user_id' => $userID, 'modification' => $modification]);
            });
        });
    }

    public function calculateUserPoints(int|Event $event, int|User $user): ?array
    {
        $event = is_int($event) ? Event::findOrFail($event) : $event;
        $user = is_int($user) ? User::findOrFail($user) : $user;
        $eventLevel = $event->main_event_level;

        $winnerMember = $event->members()->with('winner')->whereHas('winner')->where('user_id', $user->id)->first();
        if (! empty($winnerMember)) {
            return [
                'role' => $winnerMember->winner->reward_type->getDisplayName(),
                'points' => match ($winnerMember->winner->reward_type) {
                    RewardType::GRANT_RECIPIENT => match ($eventLevel) {
                        EventLevel::INTERNAL, EventLevel::INTERNAL_VUZ => null,
                        default => 14
                    },
                    RewardType::WINNER_CONCURS => match ($eventLevel) {
                        EventLevel::INTERNAL, EventLevel::INTERNAL_VUZ => 4,
                        EventLevel::CITY => 7,
                        EventLevel::REGION => 8,
                        EventLevel::DISTRICT => 9,
                        EventLevel::RUSSIA, EventLevel::INTERNATIONAL => 10,
                    },
                    default => 0
                },
            ];
        }

        if ($event->creator_id === $user->id) {
            return [
                'role' => 'Создатель мероприятия',
                'points' => match ($eventLevel) {
                    EventLevel::INTERNAL, EventLevel::INTERNAL_VUZ => 4,
                    EventLevel::CITY => 5,
                    EventLevel::REGION, EventLevel::DISTRICT => 6,
                    EventLevel::RUSSIA, EventLevel::INTERNATIONAL => 7,
                },
            ];
        }

        $coauthor = $event->coauthors()->where('user_id', $user->id)->first();
        if (! empty($coauthor)) {
            $maxPoint = 0;
            $roleName = null;
            foreach ($coauthor->roles as $role) {
                $points = match (mb_strtolower($role)) {
                    'создатель', 'организатор' => match ($eventLevel) {
                        EventLevel::INTERNAL, EventLevel::INTERNAL_VUZ => 4,
                        EventLevel::CITY => 5,
                        EventLevel::REGION, EventLevel::DISTRICT => 6,
                        EventLevel::RUSSIA, EventLevel::INTERNATIONAL => 7,
                    },
                    'волонтёр', 'волонтер' => 3,
                    'выступающий' => match ($eventLevel) {
                        EventLevel::INTERNAL, EventLevel::INTERNAL_VUZ, EventLevel::CITY => 2,
                        EventLevel::REGION, EventLevel::DISTRICT => 3,
                        EventLevel::RUSSIA, EventLevel::INTERNATIONAL => 4,
                    },
                    default => 0
                };

                if ($points > $maxPoint) {
                    $maxPoint = $points;
                    $roleName = $role;
                }
            }

            if ($maxPoint > 0) {
                return ['role' => $roleName, 'points' => $maxPoint];
            }
        }

        if ($event->members()->where('user_id', $user->id)->exists()) {
            return [
                'role' => 'Участник',
                'points' => match ($eventLevel) {
                    EventLevel::INTERNAL,
                    EventLevel::INTERNAL_VUZ,
                    EventLevel::CITY,
                    EventLevel::REGION,
                    EventLevel::DISTRICT => 1,
                    EventLevel::RUSSIA, EventLevel::INTERNATIONAL => 2,
                },
            ];
        }

        return null;
    }
}
