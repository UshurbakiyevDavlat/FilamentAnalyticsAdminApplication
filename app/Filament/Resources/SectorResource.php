<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\SectorResource\Pages\CreateSector;
use App\Filament\Resources\SectorResource\Pages\EditSector;
use App\Filament\Resources\SectorResource\Pages\ListSectors;
use App\Models\Sector;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SectorResource extends Resource
{
    protected static ?string $model = Sector::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('sectors.title'))
                    ->autofocus()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('sectors.title'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('sectors.created_at'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSectors::route('/'),
            'create' => CreateSector::route('/create'),
            'edit' => EditSector::route('/{record}/edit'),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('menu.sector');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('menu.sector');
    }

    /**
     * Get the displayable plural label of the resource.
     *
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return __('menu.sector');
    }
}
