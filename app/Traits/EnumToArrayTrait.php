<?php

namespace App\Traits;

trait EnumToArrayTrait
{
    public function getDisplayName(): string
    {
        return 'undefined';
    }

    public static function toArray(): array
    {
        return collect(static::cases())->map(fn ($element) => $element->toArrayElement())->toArray();
    }

    public static function toArrayAdditionalDataMapping(self $element): array
    {
        return [];
    }

    public function toArrayElement(): array
    {
        return array_merge([
            'value' => $this->value,
            'sys_name' => $this->name,
            'display_name' => $this->getDisplayName(),
        ], static::toArrayAdditionalDataMapping($this));
    }
}
