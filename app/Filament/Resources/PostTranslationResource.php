<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PostTranslationResource\Pages\CreatePostTranslation;
use App\Filament\Resources\PostTranslationResource\Pages\EditPostTranslation;
use App\Filament\Resources\PostTranslationResource\Pages\ListPostTranslations;
use App\Helpers\TranslationHelper;
use App\Models\PostTranslation;
use Exception;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class PostTranslationResource extends Resource
{
    /**
     * The max value of the title.
     *
     * @var int
     */
    private const TITLE_MAX_LENGTH = 100;

    /**
     * The displayable name of the resource being managed.
     *
     * @var string|null
     */
    protected static ?string $model = PostTranslation::class;

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
                    ->label(__('post.title'))
                    ->required()
                    ->maxValue(self::TITLE_MAX_LENGTH)
                    ->placeholder(__('post.placeholder.title')),

                TextArea::make('desc')
                    ->label(__('post.short_description'))
                    ->required()
                    ->placeholder(__('post.placeholder.short_description')),

                TinyEditor::make('content')
                    ->label(__('post.content'))
                    ->required()
                    ->placeholder(__('post.placeholder.content')),

                Select::make('locale_id')
                    ->relationship('locale', 'locale')
                    ->label(__('locale.locale'))
                    ->hidden(static fn(Get $get) => TranslationHelper::isHide(
                        $get('locale_id'),
                        $get('post_id'),
                        'post_id',
                        new PostTranslation(),
                    ))
                    ->required()
                    ->live()
                    ->required(),

                Select::make('post_id')
                    ->relationship('post', 'title')
                    ->label(__('post.label'))
                    ->live()
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

                TextColumn::make('post.title')
                    ->label(__('post.title'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('locale_id')
                    ->relationship('locale', 'locale')
                    ->label(__('locale.locale')),

                SelectFilter::make('post_id')
                    ->relationship('post', 'title')
                    ->label(__('post.label')),
            ], FiltersLayout::AboveContent)
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Relation configuration.
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
     * Page configuration.
     *
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => ListPostTranslations::route('/'),
            'create' => CreatePostTranslation::route('/create'),
            'edit' => EditPostTranslation::route('/{record}/edit'),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('menu.post_translation');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('menu.post_translation');
    }

    /**
     * Get the displayable plural label of the resource.
     *
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return __('menu.post_translation');
    }
}
