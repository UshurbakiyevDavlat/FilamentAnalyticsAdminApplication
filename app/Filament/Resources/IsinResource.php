<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\TickerIsinIntFavoriteEnum;
use App\Enums\TickerIsinIntStatusEnum;
use App\Filament\Resources\IsinResource\Pages\CreateIsin;
use App\Filament\Resources\IsinResource\Pages\EditIsin;
use App\Filament\Resources\IsinResource\Pages\ListIsins;
use App\Models\Isin;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IsinResource extends Resource
{
    protected static ?string $model = Isin::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label(__('isin.code'))
                    ->autofocus()
                    ->required(),

                Toggle::make('is_active')
                    ->label(__('isin.is_active'))
                    ->required(),

                Toggle::make('is_favorite')
                    ->label(__('isin.is_favorite'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(__('isin.code'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('isin.created_at'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('is_active')
                    ->label(__('isin.is_active'))
                    ->formatStateUsing(
                        fn(string $state): string => $state == TickerIsinIntStatusEnum::ACTIVE->value
                            ? __('isin.active')
                            : __('isin.inactive'),
                    )->sortable(),

                TextColumn::make('is_favorite')
                    ->label(__('isin.is_favorite'))
                    ->formatStateUsing(
                        fn(string $state): string => $state == TickerIsinIntFavoriteEnum::FAVORITE->value
                            ? __('isin.favorite')
                            : __('isin.not_favorite'),
                    )->sortable(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIsins::route('/'),
            'create' => CreateIsin::route('/create'),
            'edit' => EditIsin::route('/{record}/edit'),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('menu.isin');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('menu.isin');
    }

    /**
     * Get the displayable plural label of the resource.
     *
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return __('menu.isin');
    }
}
