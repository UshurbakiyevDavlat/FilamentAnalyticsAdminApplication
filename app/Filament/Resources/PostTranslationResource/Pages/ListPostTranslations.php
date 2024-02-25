<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostTranslationResource\Pages;

use App\Filament\Resources\PostTranslationResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;

class ListPostTranslations extends ListRecords
{
    /**
     * @var string Resource class name
     */
    protected static string $resource = PostTranslationResource::class;

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
