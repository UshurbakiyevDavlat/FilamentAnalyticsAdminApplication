<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\FileUploadIntEnum;
use App\Enums\PlaceHoldersEnum;
use App\Filament\Resources\EcosystemResource\Pages\CreateEcosystem;
use App\Filament\Resources\EcosystemResource\Pages\EditEcosystem;
use App\Filament\Resources\EcosystemResource\Pages\ListEcosystems;
use App\Models\Ecosystem;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EcosystemResource extends Resource
{
    /**
     * Model class name
     *
     * @var string|null
     */
    protected static ?string $model = Ecosystem::class;

    /**
     * Icon for navigation
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Form function
     *
     * @param Form $form Form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('website')
                    ->url()
                    ->placeholder(PlaceHoldersEnum::WEBSITE->value)
                    ->label(__('ecosystem.website'))
                    ->required()
                    ->unique('ecosystem', 'website')
                    ->autofocus(),

                FileUpload::make('img')
                    ->directory('ecosystems')
                    ->maxSize(FileUploadIntEnum::IMAGE_MAX_SIZE->value)
                    ->visibility('public')
                    ->downloadable()
                    ->label(__('ecosystem.img'))
                    ->image(),
            ]);
    }

    /**
     * Table function
     *
     * @param Table $table Table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('website')
                    ->sortable()
                    ->searchable(),

                ImageColumn::make('img'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Get relation managers
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * Get pages
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ListEcosystems::route('/'),
            'create' => CreateEcosystem::route('/create'),
            'edit' => EditEcosystem::route('/{record}/edit'),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('menu.ecosystem');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('menu.ecosystem');
    }

    /**
     * Get the displayable plural label of the resource.
     *
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return __('menu.ecosystem');
    }
}
