<?php

namespace App\Enums;

use App\Traits\EnumToArrayTrait;

enum ActivityDirection: string
{
    use EnumToArrayTrait;

    case SPIRITUAL_AND_MORAL = 'spi_mor';
    case CIVIL_LAW = 'civ_law';
    case PATRIOTIC = 'patriot';
    case PROFESSIONAL_AND_LABOR = 'prof_lab';
    case CULTURAL_AND_CREATIVE = 'cult_cre';
    case SCIENTIFIC_AND_EDUCATIONAL = 'sci_ed';
    case PHYSICAL = 'phys';
    case ENVIRONMENTAL = 'env';
    case INFORMATION = 'inf';
    case TOURIST = 'tour';
    case ENTREPRENEURIAL = 'ent';

    public function getDisplayName(): string
    {
        return match ($this) {
            self::SPIRITUAL_AND_MORAL => 'Духовно-нравственное воспитание',
            self::CIVIL_LAW => 'Гражданско-правовое воспитание',
            self::PATRIOTIC => 'Патриотическое воспитание',
            self::PROFESSIONAL_AND_LABOR => 'Профессионально-трудовое воспитание',
            self::CULTURAL_AND_CREATIVE => 'Культурно-творческое воспитание',
            self::SCIENTIFIC_AND_EDUCATIONAL => 'Научно-образовательное воспитание',
            self::PHYSICAL => 'Физическое воспитание',
            self::ENVIRONMENTAL => 'Экологическое воспитание',
            self::INFORMATION => 'Информационное',
            self::TOURIST => 'Туристическое',
            self::ENTREPRENEURIAL => 'Предпринимательское',
        };
    }
}
