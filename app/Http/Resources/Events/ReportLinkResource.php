<?php

namespace App\Http\Resources\Events;

use App\Models\EventReportLink;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin EventReportLink */
class ReportLinkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'link' => $this->link,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'event_id' => $this->event_id,

            'event' => new ShortResource($this->whenLoaded('event')),
        ];
    }
}
