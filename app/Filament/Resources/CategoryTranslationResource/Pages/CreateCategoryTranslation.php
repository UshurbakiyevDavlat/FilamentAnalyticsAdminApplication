<?php

declare(strict_types=1);

namespace App\Filament\Resources\CategoryTranslationResource\Pages;

use App\Filament\Resources\CategoryTranslationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryTranslation extends CreateRecord
{
    /**
     * @var string Resource class name
     */
    protected static string $resource = CategoryTranslationResource::class;

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
