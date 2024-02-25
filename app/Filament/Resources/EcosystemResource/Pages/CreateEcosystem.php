<?php

declare(strict_types=1);

namespace App\Filament\Resources\EcosystemResource\Pages;

use App\Filament\Resources\EcosystemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEcosystem extends CreateRecord
{
    /**
     * Resource class name for the model being managed.
     *
     * @var string
     */
    protected static string $resource = EcosystemResource::class;

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
