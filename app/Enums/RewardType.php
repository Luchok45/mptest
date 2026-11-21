<?php

namespace App\Enums;

use App\Traits\EnumToArrayTrait;

enum RewardType: string
{
    use EnumToArrayTrait;

    case WINNER_CONCURS = 'winner-concurs';
    case GRANT_RECIPIENT = 'grant-recipient';

    public function getDisplayName(): string
    {
        return match ($this) {
            self::WINNER_CONCURS => 'Победитель конкурса творческого, общественного, спортивного, научного конкурса',
            self::GRANT_RECIPIENT => 'Получатель гранта социального/научного',
        };
    }
}
