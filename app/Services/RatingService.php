<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\Balance;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class RatingService
{
    public function recalculateCache(): void
    {
        Cache::lock('rating', 300)->block(300, function () {
            $users = Rating::query()
                ->select(['user_id'])
                ->orderBy('user_id')
                ->pluck('user_id')
                ->toArray();

            $rating = [];
            foreach ($users as $userID) {
                $this->recalculateForUser($userID);
                $rating[] = [
                    'user_id' => $userID,
                    'points' => Cache::tags(['rating'])->get("rating-user-$userID"),
                ];
            }
            usort($rating, fn ($a, $b) => $b['points'] <=> $a['points']);
            $rating = array_slice($rating, 0, 30);
            foreach ($rating as &$item) {
                $user = User::find($item['user_id']);
                $item['user'] = UserResource::make($user)->resolve();
            }
            Cache::tags(['rating'])->forever('rating', $rating);
        });
    }

    public function recalculateForUser(int|User $userID): void
    {
        $userID = is_int($userID) ? $userID : $userID->id;
        Cache::lock('rating-user-'.$userID, 30)->block(30, function () use ($userID) {
            Cache::tags(['rating'])->forever(
                "rating-user-$userID",
                Rating::where('user_id', $userID)->sum('modification')
            );
            Cache::tags(['balance'])->forever(
                "balance-user-$userID",
                Balance::where('user_id', $userID)->sum('modification')
            );
        });
    }

    public function getRatingResponse(): array
    {
        return Cache::tags(['rating'])->get('rating');
    }
}
