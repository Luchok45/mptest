<?php

namespace App\Http\Requests\Events;

use App\Enums\ActivityDirection;
use App\Enums\EventLevel;
use App\Enums\YouthPolicyDirection;
use App\Models\Event;
use App\Services\FilePreloadService\FilePreloadServiceInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    protected ?Event $event = null;

    public function rules(): array
    {
        return [
            'main_name' => ['required', 'string', 'max:255'],
            'main_event_level' => ['required', 'string', Rule::enum(EventLevel::class)],
            'main_activity_direction' => ['required', 'string', Rule::enum(ActivityDirection::class)],
            'main_youth_policy_direction' => ['required', 'string', Rule::enum(YouthPolicyDirection::class)],
            'dates_start_date' => ['required', 'date'],
            'dates_end_date' => ['nullable', 'date', 'after_or_equal:dates_start_date'],
            'dates_start_time' => ['required', 'date_format:H:i:s'],
            'plan_target_audience' => ['nullable', 'string', 'max:1000'],
            'plan_description' => ['nullable', 'string', 'max:1000'],
            'plan_target_smart' => ['nullable', 'string', 'max:1000'],
            'plan_qualitative_indicators' => ['nullable', 'string', 'max:1000'],
            'plan_scenario_file' => ['nullable', 'file', 'mimes:doc,docx,pdf,rtf,txt,xls,xlsx', 'max:20480'],
            'plan_estimate_file' => ['nullable', 'file', 'mimes:doc,docx,pdf,rtf,txt,xls,xlsx', 'max:20480'],
            'announcement_enabled' => ['required', 'boolean'],
            'announcement_description' => ['nullable', 'required_if_accepted:announcement_enabled', 'string', 'max:2500'],
            'announcement_image_file' => ['nullable', empty($this->event) ? 'required_if_accepted:announcement_enabled' : '', 'image', 'mimes:jpeg,png,jpg', 'max:10240'],
            'registration_enabled' => ['required', 'boolean'],
            'registration_end_date' => ['nullable', 'required_if_accepted:registration_enabled', 'date'],
            'registration_members_count' => ['nullable', 'required_if_accepted:registration_enabled', 'integer', 'min:0', 'max:200'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('events.create')
            && (empty($this->event) || $this->event->isCreatorOrCoauthor($this->user()));
    }

    protected function prepareForValidation(): void
    {
        $this->event = $this->route('event');
    }

    protected function passedValidation(): void
    {
        $this->prepareFiles();
    }

    public function getValidatedData(): array
    {
        return array_merge(
            Arr::except($this->validated(), ['plan_scenario_file', 'plan_estimate_file', 'announcement_image_file']),
            [
                'plan_scenario_file' => $this->input('plan_scenario_file'),
                'plan_estimate_file' => $this->input('plan_estimate_file'),
                'announcement_image_file' => $this->input('announcement_image_file'),
            ]
        );
    }

    protected function prepareFiles(): void
    {
        $this->replace([
            ...$this->updateFileIfNeeded('plan_scenario_file'),
            ...$this->updateFileIfNeeded('plan_estimate_file'),
            ...$this->updateFileIfNeeded('announcement_image_file'),
        ]);
    }

    protected function updateFileIfNeeded(string $key): array
    {
        if (! empty($this->$key)) {
            return [
                $key => app(
                    FilePreloadServiceInterface::class)->save($this->file($key),
                        'events'
                    ),
            ];
        } elseif (! empty($this->event)) {
            return [$key => $this->event->$key];
        }

        return [];
    }
}
