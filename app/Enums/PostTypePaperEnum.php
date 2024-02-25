<?php

namespace App\Enums;

enum PostTypePaperEnum: int
{
    case SHARES = 1;
    case OBLIGATIONS = 2;

    /**
     * Get the access shares.
     *
     * @param int|string|null $value
     * @return bool
     */
    public static function getAccessShares(int|string|null $value): bool
    {
        if (is_null($value)) {
            return false;
        }

        return (int) $value !== self::SHARES->value;
    }

    /**
     * Get the access obligations.
     *
     * @param int|string|null $value
     * @return bool
     */
    public static function getAccessObligations(int|string|null $value): bool
    {
        if (is_null($value)) {
            return false;
        }

        return (int) $value !== self::OBLIGATIONS->value;
    }
}
