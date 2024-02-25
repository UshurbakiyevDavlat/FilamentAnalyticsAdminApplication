<?php

declare(strict_types=1);

namespace App\Filament\Resources\IsinResource\Pages;

use App\Filament\Resources\IsinResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIsins extends ListRecords
{
    protected static string $resource = IsinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
