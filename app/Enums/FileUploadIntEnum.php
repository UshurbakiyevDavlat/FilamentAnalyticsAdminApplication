<?php

declare(strict_types=1);

namespace App\Enums;

enum FileUploadIntEnum: int
{
    case DOCUMENT_MAX_SIZE = 20000;
    case IMAGE_MAX_SIZE = 1024;
}
