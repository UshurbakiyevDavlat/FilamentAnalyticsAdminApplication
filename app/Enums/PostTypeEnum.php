<?php

namespace App\Enums;

enum PostTypeEnum: int
{
    case INVEST_IDEA = 1;
    case NEWS = 2;

    /**
     * Get the access to invest idea.
     *
     * @param int|string|null $value
     * @return bool
     */
    public static function getAccessInvestIdea(int|string|null $value): bool
    {
        if (is_null($value)) {
            return false;
        }

        return (int) $value !== self::INVEST_IDEA->value;
    }

    /**
     * Get the access to news.
     *
     * @param int|string|null $value
     * @return bool
     */
    public static function getAccessNews(int|string|null $value): bool
    {
        if (is_null($value)) {
            return true;
        }

        return (int) $value !== self::NEWS->value;
    }
}
