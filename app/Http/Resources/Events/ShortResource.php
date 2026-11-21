<?php

namespace App\Http\Resources\Events;

use App\Http\Resources\UserResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Event */
class ShortResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status->toArrayElement(),
            'name' => $this->main_name,
            'date' => $this->dates_start_date->toIso8601String(),
            'image' => $this->announcement_image_file,
            'creator_id' => $this->creator_id,
            'creator' => new UserResource($this->whenLoaded('creator')),
            'registration_enabled' => $this->registration_enabled,
            'registration_end_date' => $this->registration_end_date?->toIso8601String(),
            'registration_members_count' => $this->registration_members_count,
            'registration_registered_members' => $this->members()->count(),
        ];
    }
}
