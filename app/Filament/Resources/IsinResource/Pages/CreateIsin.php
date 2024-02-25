<?php

declare(strict_types=1);

namespace App\Filament\Resources\IsinResource\Pages;

use App\Filament\Resources\IsinResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIsin extends CreateRecord
{
    protected static string $resource = IsinResource::class;

    /**
     * Get the URL to redirect to after a record is modified.
     *
     * @return string
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
