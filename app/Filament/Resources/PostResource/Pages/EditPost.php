<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Guava\FilamentDrafts\Admin\Resources\Pages\Edit\Draftable;

class EditPost extends EditRecord
{
    use Draftable;

    /**
     * resource class name for the model being managed
     *
     * @var string
     */
    protected static string $resource = PostResource::class;

    /**
     * Get header actions for the page.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

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
     * Mutate the form data before it is used to save record.
     *
     * @param array $data
     *
     * @return array
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // app()->make(FileService::class)->upload(
        //     $data['files'],
        //     $this->record->getKey(),
        // );
        //
        // unset($data['files']);

        $was_published = $this->record->getAttribute('published_at');

        if (!$this->shouldSaveAsDraft && empty($was_published)) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
