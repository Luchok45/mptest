<?php

namespace App\Models;

use App\Enums\RewardType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['event_id', 'event_member_id', 'reward_type'])]
class EventMemberWinner extends Model
{
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function eventMember(): BelongsTo
    {
        return $this->belongsTo(EventMember::class);
    }

    protected function casts(): array
    {
        return [
            'reward_type' => RewardType::class,
        ];
    }
}
