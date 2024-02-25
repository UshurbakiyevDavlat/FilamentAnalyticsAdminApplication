<?php

namespace App\Filament\Resources\EcosystemResource\Pages;

use App\Filament\Resources\EcosystemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEcosystem extends EditRecord
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
            Actions\DeleteAction::make(),
        ];
    }

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
