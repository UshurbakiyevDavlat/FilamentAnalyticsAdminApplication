<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\FileUploadIntEnum;
use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    /**
     * The displayable name of the resource being managed.
     *
     * @var string|null
     */
    protected static ?string $model = Category::class;

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
                    ->label(__('category.title'))
                    ->autofocus()
                    ->required()
                    ->maxValue(100)
                    ->placeholder(__('category.enter_title')),

                TextInput::make('description')
                    ->label(__('category.desc'))
                    ->required()
                    ->maxValue(100)
                    ->placeholder(__('category.enter_desc')),

                Select::make('parent_id')
                    ->label(__('category.parent'))
                    ->relationship('parent', 'title')
                    ->placeholder(__('category.select_parent')),

                Select::make('status_id')
                    ->label(__('category.status'))
                    ->required()
                    ->relationship('status', 'title')
                    ->placeholder(__('category.select_status')),

                FileUpload::make('img')
                    ->label(__('category.image'))
                    ->downloadable()
                    ->image()
                    ->directory('/categories/icons')
                    ->visibility('public')
                    ->maxSize(FileUploadIntEnum::IMAGE_MAX_SIZE->value)
                    ->storeFileNamesIn('attachment_file_names')
            ]);
    }

    /**
     * Table configuration.
     *
     * @param Table $table The table instance.
     * @return Table
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('category.id'))
                    ->sortable(),

                TextColumn::make('title')
                    ->label(__('category.title'))
                    ->searchable(),

                TextColumn::make('description')
                    ->label(__('category.desc'))
                    ->searchable()
                    ->default('None'),

                TextColumn::make('posts_count')
                    ->sortable()
                    ->badge()
                    ->label(__('category.posts_count'))
                    ->counts('posts'),

                TextColumn::make('parent.title')
                    ->searchable()
                    ->default('None')
                    ->label(__('category.parent'))
                    ->sortable(),

                ToggleColumn::make('status_id')->updateStateUsing(
                    function ($state, $record) {
                        $record->status_id = $state
                            ? 1
                            : 2;

                        $record->save();

                        return $state;
                    },
                )
                    ->label(__('category.status')),

                TextColumn::make('created_at')
                    ->label(__('category.created_at'))
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label(__('category.updated_at'))
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('parent_id')
                    ->label(__('filters.parent_category'))
                    ->options(self::getTypeMap()),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    /**
     * Get relations for resource.
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
     * Get pages for resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    /**
     * Get type map for resource.
     *
     * @return Closure
     */
    private static function getTypeMap(): Closure
    {
        $subcategories = static fn(): array => Category::whereNotNull('parent_id')
            ->get()
            ->mapWithKeys(
                static fn(Category $item): array => [
                    $item->id => $item->title,
                ],
            )->toArray();

        $categories = static fn(): array => Category::whereNull('parent_id')
            ->get()
            ->mapWithKeys(
                static fn(Category $item): array => [
                    $item->id => $item->title,
                ],
            )->toArray();

        return static fn(): array => [
            __('category.type.parent') => $categories(),
            __('category.type.child') => $subcategories(),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('menu.category');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('menu.category');
    }

    /**
     * Get the displayable plural label of the resource.
     *
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return __('menu.category');
    }
}
