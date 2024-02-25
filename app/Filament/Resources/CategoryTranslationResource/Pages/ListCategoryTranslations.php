<?php

declare(strict_types=1);

namespace App\Filament\Resources\CategoryTranslationResource\Pages;

use App\Filament\Resources\CategoryTranslationResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;

class ListCategoryTranslations extends ListRecords
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
            Actions\CreateAction::make(),
        ];
    }
}
