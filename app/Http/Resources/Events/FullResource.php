<?php

namespace App\Http\Resources\Events;

use App\Http\Resources\UserResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Event */
class FullResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'system' => [
                'status' => $this->status->toArrayElement(),
                'reject_comment' => $this->reject_comment,
            ],

            'main' => [
                'name' => $this->main_name,
                'event_level' => $this->main_event_level->toArrayElement(),
                'activity_direction' => $this->main_activity_direction->toArrayElement(),
                'youth_policy_direction' => $this->main_youth_policy_direction->toArrayElement(),
            ],

            'dates' => [
                'start_date' => $this->dates_start_date->toIso8601String(),
                'end_date' => $this->dates_end_date?->toIso8601String(),
                'start_time' => $this->dates_start_time?->format('H:i:s'),
            ],

            'plan' => [
                'target_audience' => $this->plan_target_audience,
                'description' => $this->plan_description,
                'target_smart' => $this->plan_target_smart,
                'qualitative_indicators' => $this->plan_qualitative_indicators,
                'scenario_file' => $this->plan_scenario_file,
                'estimate_file' => $this->plan_estimate_file,
            ],

            'announcement' => [
                'enabled' => $this->announcement_enabled,
                'description' => $this->announcement_description,
                'image_file' => $this->announcement_image_file,
                'link'  => $this->announcement_enabled ? route('announcements.show', $this->id) : null,
            ],

            'registration' => [
                'enabled' => $this->registration_enabled,
                'end_date' => $this->registration_end_date?->toIso8601String(),
                'members_count' => $this->registration_members_count,
            ],

            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),

            'creator_id' => $this->creator_id,

            $this->mergeWhen($this->relationLoaded('creator'), [
                'creator' => (new UserResource($this->creator))->resolve(),
            ]),
            $this->mergeWhen($this->relationLoaded('coauthors'), [
                'coauthors' => CoauthorResource::collection($this->coauthors->load('user'))->resolve(),
            ]),
            $this->mergeWhen($this->relationLoaded('members'), [
                'members' => MemberResource::collection($this->members->load('user'))->resolve(),
            ]),

            $this->mergeWhen($this->relationLoaded('winners'), [
                'winners' => MemberWinnerResource::collection($this->winners->load('eventMember', 'eventMember.user'))->resolve(),
            ]),

            $this->mergeWhen($this->relationLoaded('reportLinks'), [
                'report_links' => ReportLinkResource::collection($this->reportLinks)->resolve(),
            ]),

            'coauthors_count' => $this->coauthors()->count(),
            'members_count' => $this->members()->count(),
        ];
    }
}
