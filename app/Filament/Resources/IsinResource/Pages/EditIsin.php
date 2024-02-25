<?php

declare(strict_types=1);

namespace App\Filament\Resources\IsinResource\Pages;

use App\Filament\Resources\IsinResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\EditRecord;

class EditIsin extends EditRecord
{
    protected static string $resource = IsinResource::class;

    /**
     * Get the actions available on the page.
     *
     * @return array|Action[]|ActionGroup[]
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
