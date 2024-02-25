<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\TickerIsinIntFavoriteEnum;
use App\Enums\TickerIsinIntStatusEnum;
use App\Filament\Resources\TickerResource\Pages\CreateTicker;
use App\Filament\Resources\TickerResource\Pages\EditTicker;
use App\Filament\Resources\TickerResource\Pages\ListTickers;
use App\Models\Ticker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TickerResource extends Resource
{
    /**
     * Model the resource corresponds to.
     *
     * @var string|null
     */
    protected static ?string $model = Ticker::class;

    /**
     * Navigation icon for resource.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Get the form for the resource.
     *
     * @param Form $form Form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('full_name')
                    ->label(__('ticker.full_name'))
                    ->autofocus()
                    ->required()
                    ->maxValue(100)
                    ->placeholder(__('ticker.enter_full_name')),

                TextInput::make('short_name')
                    ->label(__('ticker.short_name'))
                    ->autofocus()
                    ->required()
                    ->maxValue(100)
                    ->placeholder(__('ticker.enter_short_name')),

                Toggle::make('is_active')
                    ->label(__('ticker.is_active'))
                    ->required(),

                Toggle::make('is_favorite')
                    ->label(__('ticker.is_favorite'))
                    ->required(),
            ]);
    }

    /**
     * Get the table for the resource.
     *
     * @param Table $table Table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('ticker.id')),

                TextColumn::make('full_name')
                    ->label(__('ticker.full_name'))
                    ->searchable(),

                TextColumn::make('short_name')
                    ->label(__('ticker.short_name'))
                    ->searchable(),

                TextColumn::make('is_active')
                    ->label(__('ticker.is_active'))
                    ->formatStateUsing(
                        fn(string $state): string => $state == TickerIsinIntStatusEnum::ACTIVE->value
                            ? __('ticker.active')
                            : __('ticker.inactive'),
                    )
                    ->sortable(),

                TextColumn::make('is_favorite')
                    ->label(__('ticker.is_favorite'))
                    ->formatStateUsing(
                        fn(string $state): string => $state == TickerIsinIntFavoriteEnum::FAVORITE->value
                            ? __('ticker.favorite')
                            : __('ticker.not_favorite'),
                    )
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Get the relations available for the resource.
     *
     * @return array|RelationGroup[]|RelationManagerConfiguration[]|string[]
     */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * Get the pages available for the resource.
     *
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => ListTickers::route('/'),
            'create' => CreateTicker::route('/create'),
            'edit' => EditTicker::route('/{record}/edit'),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('menu.ticker');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('menu.ticker');
    }

    /**
     * Get the displayable plural label of the resource.
     *
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return __('menu.ticker');
    }
}
