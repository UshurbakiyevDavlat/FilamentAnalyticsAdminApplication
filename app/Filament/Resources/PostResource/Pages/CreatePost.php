<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentDrafts\Admin\Resources\Pages\Create\Draftable;

class CreatePost extends CreateRecord
{
    use Draftable;

    /**
     * resource class name for the model being managed
     *
     * @var string
     */
    protected static string $resource = PostResource::class;

    /**
     * Get the URL to redirect to after a record is created.
     *
     * @return string
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Mutate the form data before it is used to create record.
     *
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!$this->shouldSaveAsDraft) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
