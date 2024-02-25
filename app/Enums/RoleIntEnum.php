<?php

namespace App\Enums;

enum RoleIntEnum: int
{
    /**
     * @const int SUPER_ADMIN
     */
    case SUPER_ADMIN = 1;

    /**
     * @const int ADMIN
     */
    case ADMIN = 2;

    /**
     * @const int ANALYST
     */
    case ANALYST = 3;

    /**
     * @const int EDITOR
     */
    case EDITOR = 4;

    /**
     * @const int READER
     */
    case READER = 5;

}
