<?php

declare(strict_types=1);

namespace App\Enums;

enum HorizonRecommendEnum: string
{
    case DEFAULT = 'default';
    case BUY = 'buy';
    case SELL = 'sell';
    case HOLD = 'hold';

    /**
     * Get recommendations.
     *
     * @return array
     */
    public static function getRecommendations(): array
    {
        $buyKey = __('recommend.' . self::BUY->value);
        $sellKey = __('recommend.' . self::SELL->value);
        $holdKey = __('recommend.' . self::HOLD->value);

        return [
            self::BUY->value => $buyKey,
            self::SELL->value => $sellKey,
            self::HOLD->value => $holdKey,
        ];
    }

    /**
     * Get default recommendations.
     *
     * @return string
     */
    public static function getDefaultRecommendation(): string
    {
        return self::BUY->value;
    }
}
