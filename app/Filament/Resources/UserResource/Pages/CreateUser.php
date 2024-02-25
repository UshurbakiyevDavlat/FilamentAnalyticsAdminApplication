<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    /**
     * resource class name for the model being managed
     *
     * @var string
     */
    protected static string $resource = UserResource::class;

    /**
     * Get the URL to redirect to after a record is created.
     *
     * @return string
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // TODO: Change the autogenerated stub
    }
}