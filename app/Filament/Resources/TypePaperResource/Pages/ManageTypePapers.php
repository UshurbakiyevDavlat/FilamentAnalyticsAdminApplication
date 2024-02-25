<?php

namespace App\Filament\Resources\TypePaperResource\Pages;

use App\Filament\Resources\TypePaperResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTypePapers extends ManageRecords
{
    /**
     * resource class name for the model being managed
     *
     * @var string
     */
    protected static string $resource = TypePaperResource::class;

    /**
     * Get header actions for the page.
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
