<?php

namespace App\Enums;

use App\Traits\EnumToArrayTrait;

enum EventStatus: string
{
    use EnumToArrayTrait;

    case DRAFT = 'draft';
    case AGREEMENT = 'agreement';
    case REVISION = 'revision';
    case PUBLISHED = 'published';
    case IN_REPORTING = 'in-reporting';
    case IN_REPORT_AGREEMENT = 'in-report-agreement';
    case IN_REPORT_REVISION = 'in-report-revision';
    case IN_REPORT_PUBLISHED = 'in-report-published';

    case ARCHIVED = 'archived';

    public function getDisplayName(): string
    {
        return match ($this) {
            self::DRAFT => 'Черновик',
            self::AGREEMENT => 'Согласование',
            self::REVISION => 'На доработке',
            self::PUBLISHED => 'Согласовано',
            self::IN_REPORTING => 'Подготовка отчёта',
            self::IN_REPORT_AGREEMENT => 'Проверка отчёта',
            self::IN_REPORT_REVISION => 'Отчёт на доработке',
            self::IN_REPORT_PUBLISHED => 'Отчёт принят',
            self::ARCHIVED => 'В архиве',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::DRAFT, self::IN_REPORTING => 'blue',
            self::AGREEMENT, self::IN_REPORT_AGREEMENT => 'yellow',
            self::REVISION, self::IN_REPORT_REVISION => 'red',
            self::PUBLISHED, self::IN_REPORT_PUBLISHED => 'green',
            self::ARCHIVED => 'gray',
        };
    }

    public static function toArrayAdditionalDataMapping(EventStatus $element): array
    {
        return [
            'display_name' => $element->getDisplayName(),
            'color' => $element->getColor(),
        ];
    }

    public static function fromFilter(string $filter): array
    {
        return match ($filter) {
            'need-action' => [
                EventStatus::REVISION,
                EventStatus::IN_REPORTING,
                EventStatus::IN_REPORT_REVISION,
            ],
            'published' => [
                EventStatus::PUBLISHED,
                EventStatus::IN_REPORT_PUBLISHED,
            ],
            'drafts' => [
                EventStatus::DRAFT,
            ],
            'on-moderation' => [
                EventStatus::AGREEMENT,
                EventStatus::IN_REPORT_AGREEMENT,
            ],

            'in-revision' => [
                EventStatus::IN_REPORT_REVISION,
                EventStatus::REVISION,
            ],
            default => EventStatus::cases(),
        };
    }
}
