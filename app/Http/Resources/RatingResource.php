<?php

namespace App\Http\Resources;

use App\Http\Resources\Events\ShortResource;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Rating */
class RatingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'modification' => $this->modification,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user_id' => $this->user_id,
            'event_id' => $this->event_id,

            'event' => new ShortResource($this->whenLoaded('event')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
