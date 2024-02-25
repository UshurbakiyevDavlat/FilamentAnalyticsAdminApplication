<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    /**
     * resource class name for the model being managed
     *
     * @var string
     */
    protected static string $resource = UserResource::class;

    /**
     * Get header actions for the page.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
