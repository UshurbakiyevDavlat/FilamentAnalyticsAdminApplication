<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryTranslationResource\Pages\CreateCategoryTranslation;
use App\Filament\Resources\CategoryTranslationResource\Pages\EditCategoryTranslation;
use App\Filament\Resources\CategoryTranslationResource\Pages\ListCategoryTranslations;
use App\Helpers\TranslationHelper;
use App\Models\CategoryTranslation;
use Exception;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CategoryTranslationResource extends Resource
{
    /**
     * The max length of the description.
     *
     * @var int
     */
    private const DESC_MAX_LENGTH = 150;

    /**
     * The max value of the title.
     *
     * @var int
     */
    private const TITLE_MAX_LENGTH = 100;

    /**
     * Model the resource corresponds to.
     *
     * @var string|null
     */
    protected static ?string $model = CategoryTranslation::class;

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
                    ->autofocus()
                    ->required()
                    ->label(__('category.title'))
                    ->maxValue(self::TITLE_MAX_LENGTH)
                    ->placeholder(__('category.enter_title')),

                TextInput::make('description')
                    ->required()
                    ->label(__('category.desc'))
                    ->maxValue(self::DESC_MAX_LENGTH)
                    ->placeholder(__('category.enter_desc')),

                Select::make('locale_id')
                    ->relationship('locale', 'locale')
                    ->label(__('locale.locale'))
                    ->live()
                    ->hidden(static fn(Get $get) => TranslationHelper::isHide(
                        $get('locale_id'),
                        $get('category_id'),
                        'category_id',
                        new CategoryTranslation(),
                    ))
                    ->required(),

                Select::make('category_id')
                    ->relationship('category', 'title')
                    ->live()
                    ->label(__('category.label'))
                    ->required(),
            ]);
    }

    /**
     * Table configuration.
     *
     * @param Table $table The table instance.
     * @return Table
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('locale.locale')
                    ->label(__('locale.locale'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.title')
                    ->label(__('category.label'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('locale_id')
                    ->label(__('locale.locale'))
                    ->relationship('locale', 'locale'),

                SelectFilter::make('category_id')
                    ->label(__('category.label'))
                    ->relationship('category', 'title')
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Get Relations for resource.
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
     * Get Pages for resource.
     *
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => ListCategoryTranslations::route('/'),
            'create' => CreateCategoryTranslation::route('/create'),
            'edit' => EditCategoryTranslation::route('/{record}/edit'),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('menu.category_translation');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('menu.category_translation');
    }

    /**
     * Get the displayable plural label of the resource.
     *
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return __('menu.category_translation');
    }
}
