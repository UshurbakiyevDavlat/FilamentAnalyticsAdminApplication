<?php

declare(strict_types=1);

namespace App\Filament\Resources\SectorResource\Pages;

use App\Filament\Resources\SectorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSector extends CreateRecord
{
    protected static string $resource = SectorResource::class;

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
