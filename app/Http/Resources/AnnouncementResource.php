<?php

namespace App\Http\Resources;

use App\Enums\EventStatus;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Event */
class AnnouncementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_date' => $this->dates_start_date?->toIso8601String(),
            'end_date' => $this->dates_end_date?->toIso8601String(),
            'start_time' => $this->dates_start_time?->format('H:i'),
            'name' => $this->main_name,
            'description' => $this->announcement_description,
            'image' => $this->announcement_image_file['public_link'] ?? null,
            'registration_enabled' => $this->registration_enabled,
            'registration_end_date' => $this->registration_end_date?->toIso8601String(),
            'registration_members_count' => $this->registration_members_count,

            'members_count' => $this->members()->count(),

            'is_registered' => $this->members()->whereUserId(auth()->id())->exists(),
            'registration_available' => $this->is_registration_available,
        ];
    }
}
