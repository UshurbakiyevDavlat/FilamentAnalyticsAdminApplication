<?php

namespace App\Filament\Resources\EcosystemResource\Pages;

use App\Filament\Resources\EcosystemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEcosystems extends ListRecords
{
    /**
     * Get the resource class that this page is for.
     *
     * @var string
     */
    protected static string $resource = EcosystemResource::class;

    /**
     * Get the actions available on the page.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
