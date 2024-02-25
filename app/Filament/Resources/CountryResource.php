<?php

namespace App\Filament\Resources;

use App\Enums\FileUploadIntEnum;
use App\Filament\Resources\CountryResource\Pages\ManageCountries;
use App\Models\Country;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CountryResource extends Resource
{
    /**
     * The displayable name of the resource being managed.
     *
     * @var string|null
     */
    protected static ?string $model = Country::class;

    /**
     * Navigation icon for resource.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Form configuration.
     *
     * @param Form $form The form instance.
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('country.title'))
                    ->required()
                    ->maxLength(255),

                FileUpload::make('img')
                    ->image()
                    ->maxSize(FileUploadIntEnum::IMAGE_MAX_SIZE->value)
                    ->directory('countries')
                    ->visibility('public')
                    ->downloadable()
                    ->label(__('country.img'))
                    ->storeFileNamesIn('origin_file_names')
            ]);
    }

    /**
     * Table configuration.
     *
     * @param Table $table The table instance.
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('country.title'))
                    ->searchable(),

                TextColumn::make('posts_count')
                    ->label(__('country.posts_count'))
                    ->sortable()
                    ->badge()
                    ->counts('posts'),

                TextColumn::make('created_at')
                    ->label(__('country.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('country.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('img')->label(__('country.img')),
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
            ])
            ->emptyStateActions([
                CreateAction::make(),
            ]);
    }

    /**
     * Get the pages available for the resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ManageCountries::route('/'),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('menu.country');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('menu.country');
    }

    /**
     * Get the displayable plural label of the resource.
     *
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return __('menu.country');
    }
}
