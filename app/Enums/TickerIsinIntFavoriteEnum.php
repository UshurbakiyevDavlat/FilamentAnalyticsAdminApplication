<?php

namespace App\Enums;

enum TickerIsinIntFavoriteEnum: int
{
    /**
     * @const int FAVORITE
     */
    case FAVORITE = 1;

    /**
     * @const int NOT_FAVORITE
     */
    case NOT_FAVORITE = 0;
}
