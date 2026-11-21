<?php

namespace App\Models;

use App\Enums\ActivityDirection;
use App\Enums\EventLevel;
use App\Enums\EventStatus;
use App\Enums\YouthPolicyDirection;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'status',
    'reject_comment',
    'main_name',
    'main_event_level',
    'main_activity_direction',
    'main_youth_policy_direction',

    'dates_start_date',
    'dates_end_date',
    'dates_start_time',

    'plan_target_audience',
    'plan_description',
    'plan_target_smart',
    'plan_qualitative_indicators',
    'plan_scenario_file',
    'plan_estimate_file',

    'announcement_enabled',
    'announcement_description',
    'announcement_image_file',

    'registration_enabled',
    'registration_end_date',
    'registration_members_count',

    'creator_id',
])]
class Event extends Model
{
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    protected function casts(): array
    {
        return [
            'status' => EventStatus::class,
            'main_event_level' => EventLevel::class,
            'main_activity_direction' => ActivityDirection::class,
            'main_youth_policy_direction' => YouthPolicyDirection::class,
            'dates_start_date' => 'date',
            'dates_end_date' => 'date',
            'dates_start_time' => 'datetime',
            'plan_scenario_file' => 'json',
            'plan_estimate_file' => 'json',
            'announcement_enabled' => 'boolean',
            'announcement_image_file' => 'json',
            'registration_enabled' => 'boolean',
            'registration_end_date' => 'date',
        ];
    }

    public function coauthors(): HasMany
    {
        return $this->hasMany(Coauthor::class, 'event_id')
            ->orderBy('id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(EventMember::class, 'event_id')
            ->orderBy('created_at');
    }

    public function winners(): HasMany
    {
        return $this->hasMany(EventMemberWinner::class, 'event_id')
            ->orderBy('created_at');
    }

    public function reportLinks(): HasMany
    {
        return $this->hasMany(EventReportLink::class, 'event_id');
    }

    public function isCreatorOrCoauthor(int|User $user): bool
    {
        $uID = is_numeric($user) ? $user : $user->id;

        return $this->creator_id === $uID
            || $this->coauthors()->whereUserId($uID)->exists();
    }

    protected function isRegistrationAvailable(): Attribute
    {
        return Attribute::make(get: fn () => $this->announcement_enabled
            && $this->status === EventStatus::PUBLISHED
            && $this->members()->whereUserId(auth()->id())->doesntExist()
            && $this->registration_enabled
            && ! empty($this->registration_end_date)
            && $this->registration_end_date->endOfDay() >= now()
            && (($this->registration_members_count ?? 0) === 0 || $this->registration_members_count >= $this->members()->count())
        );
    }

    /**
     * @param  Builder<Event>  $query
     */
    #[Scope]
    protected function my(Builder $query): void
    {
        $query->where(
            fn ($q) => $q->where('creator_id', auth()->id())
                ->orWhereRelation('coauthors', 'user_id', auth()->id())
        );
    }

    /**
     * @param  Builder<Event>  $query
     * @param  array<string>  $statuses
     */
    #[Scope]
    protected function statusFilter(Builder $query, array $statuses = []): void
    {
        $query->when(! empty($statuses), fn (Builder $q) => $q->where(
            fn ($qq) => $qq->whereIn('status', $statuses)
        ));
    }
}
