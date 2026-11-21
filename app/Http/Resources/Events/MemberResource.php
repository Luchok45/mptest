<?php

namespace App\Http\Resources\Events;

use App\Http\Resources\UserResource;
use App\Models\EventMember;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin EventMember */
class MemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            $this->mergeWhen($this->relationLoaded('event'), [
                'event' => ShortResource::make($this->event)->resolve(),
            ]),
            $this->mergeWhen($this->relationLoaded('user'), [
                'user' => UserResource::make($this->user)->resolve(),
            ]),
        ];
    }
}
