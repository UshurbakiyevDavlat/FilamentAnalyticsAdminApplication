<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostTranslationResource\Pages;

use App\Filament\Resources\PostTranslationResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePostTranslation extends CreateRecord
{
    /**
     * @var string Resource class name
     */
    protected static string $resource = PostTranslationResource::class;

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
