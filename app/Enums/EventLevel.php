<?php

namespace App\Enums;

use App\Traits\EnumToArrayTrait;

enum EventLevel: string
{
    use EnumToArrayTrait;

    case INTERNAL = 'internal';
    case INTERNAL_VUZ = 'internal-vuz';
    case CITY = 'city';
    case REGION = 'region';
    case DISTRICT = 'district';
    case RUSSIA = 'russia';
    case INTERNATIONAL = 'international';

    public function getDisplayName(): string
    {
        return match ($this) {
            self::INTERNAL => 'Внутри СС или структурного подразделения',
            self::INTERNAL_VUZ => 'Внутривузовский',
            self::CITY => 'Городской',
            self::REGION => 'Региональный',
            self::DISTRICT => 'Окружной',
            self::RUSSIA => 'Всероссийский',
            self::INTERNATIONAL => 'Международный',
        };
    }
}
