<?php

namespace App\Filament\Resources\TickerResource\Pages;

use App\Filament\Resources\TickerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTicker extends CreateRecord
{
    /**
     * The resource class this page belongs to.
     *
     * @var string $resource
     */
    protected static string $resource = TickerResource::class;

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
