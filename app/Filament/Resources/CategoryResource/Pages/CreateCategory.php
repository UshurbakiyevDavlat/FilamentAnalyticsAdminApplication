<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    /**
     * resource class name for the model being managed
     *
     * @var string
     */
    protected static string $resource = CategoryResource::class;

    /**
     * Get the URL to redirect to after a record is created.
     *
     * @return string
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
