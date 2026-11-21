<?php

namespace App\Http\Resources\Events;

use App\Models\EventMemberWinner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin EventMemberWinner */
class MemberWinnerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'event_member_id' => $this->event_member_id,
            'reward_type' => $this->reward_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            $this->mergeWhen($this->relationLoaded('event'), [
                'event' => ShortResource::make($this->event)->resolve(),
            ]),

            $this->mergeWhen($this->relationLoaded('eventMember'), [
                'member' => MemberResource::make($this->eventMember)->resolve(),
            ]),
        ];
    }
}
