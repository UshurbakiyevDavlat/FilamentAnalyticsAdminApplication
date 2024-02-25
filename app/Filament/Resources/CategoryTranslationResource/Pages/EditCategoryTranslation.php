<?php

declare(strict_types=1);

namespace App\Filament\Resources\CategoryTranslationResource\Pages;

use App\Filament\Resources\CategoryTranslationResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\EditRecord;

class EditCategoryTranslation extends EditRecord
{
    /**
     * @var string Resource class name
     */
    protected static string $resource = CategoryTranslationResource::class;

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
