<?php

declare(strict_types=1);

namespace App\Enums;

enum HorizonRiskEnum: string
{
    case DEFAULT = 'default';
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case VERY_HIGH = 'very_high';

    /**
     * Get risks.
     *
     * @return array
     */
    public static function getRisks(): array
    {
        $lowKey = __('risks.' . self::LOW->value);
        $mediumKey = __('risks.' . self::MEDIUM->value);
        $highKey = __('risks.' . self::HIGH->value);
        $veryHighKey = __('risks.' . self::VERY_HIGH->value);

        return [
            self::LOW->value => $lowKey,
            self::MEDIUM->value => $mediumKey,
            self::HIGH->value => $highKey,
            self::VERY_HIGH->value => $veryHighKey,
        ];
    }

    /**
     * Get default risk.
     *
     * @return string
     */
    public static function getDefaultRisk(): string
    {
        return self::LOW->value;
    }
}
