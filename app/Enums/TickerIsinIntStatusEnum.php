<?php

namespace App\Enums;

enum TickerIsinIntStatusEnum: int
{
    /**
     * @const int ACTIVE
     */
    case ACTIVE = 1;

    /**
     * @const int INACTIVE
     */
    case INACTIVE = 0;
}
