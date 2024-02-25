<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\FileUploadIntEnum;
use App\Enums\HorizonRecommendEnum;
use App\Enums\HorizonRiskEnum;
use App\Enums\PostTypeEnum;
use App\Enums\PostTypePaperEnum;
use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Closure;
use Exception;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;
use Illuminate\Database\Eloquent\Builder;

class PostResource extends Resource
{
    use Draftable;

    /**
     * The DEFAULT value for fields.
     *
     * @var int DEFAULT_VALUE_FOR_FIELDS
     */
    private const DEFAULT_VALUE_FOR_FIELDS = 1;

    /**
     * The max length of the description.
     *
     * @var int
     */
    private const DESC_MAX_LENGTH = 300;

    /**
     * The max value of the title.
     *
     * @var int
     */
    private const TITLE_MAX_LENGTH = 100;

    /**
     * The active status value
     *
     * @var int
     */
    private const ACTIVE = 1;

    /**
     * The non-active status value
     *
     * @var int
     */
    private const NON_ACTIVE = 2;

    /**
     * The displayable name of the resource being managed.
     *
     * @var string|null
     */
    protected static ?string $model = Post::class;

    /**
     * Navigation icon for resource.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Get users map-list. With id as key and name as value.
     *
     * @return Closure
     */
    private static function getUsersNamesMap(): Closure
    {
        return static fn(): array => User::all()
            ->mapWithKeys(
                static fn(User $user): array => [
                    $user->id => $user->name
                ]
            )->all();
    }

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
                Section::make(__('post.label'))->schema([
                    TextInput::make('title')
                        ->label(__('post.title'))
                        ->autofocus()
                        ->required()
                        ->default('Draft')
                        ->maxValue(self::TITLE_MAX_LENGTH)
                        ->placeholder(__('post.placeholder.title')),

                    Select::make('post_type_id')
                        ->label(__('post.type'))
                        ->required()
                        ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                        ->live()
                        ->options([
                            PostTypeEnum::INVEST_IDEA->value => __('post_type.invest_idea'),
                            PostTypeEnum::NEWS->value => __('post_type.news'),
                        ]),

                    Select::make('type_paper_id')
                        ->label(__('post.paper_type'))
                        ->required()
                        ->live()
                        ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                        ->relationship('typePaper', 'title'),

                    Select::make('category_id')
                        ->label(__('post.category'))
                        ->required()
                        ->live()
                        ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                        ->relationship('category', 'title'),

                    Select::make('subcategory_id')
                        ->required()
                        ->label(__('post.subcategory'))
                        ->live()
                        ->options(fn(Get $get) => self::getSubCategoriesMap($get('category_id')))
                        ->default(fn(Get $get) => self::getSubCategoriesMap($get('category_id'))[0] ?? Category::all()->random()->id)
                        ->selectablePlaceholder(false),

                    Select::make('author_id')
                        ->required()
                        ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                        ->label(__('post.author'))
                        ->options(self::getUsersNamesMap()),

                    DatePicker::make('expired_at')
                        ->hidden(fn(Get $get) => PostTypeEnum::getAccessInvestIdea($get('post_type_id')))
                        ->label(__('post.expired'))
                        ->default(now()->addDays(30))
                        ->required(),

                    Select::make('tags')
                        ->label(__('post.tag'))
                        ->relationship('tags', 'title')
                        ->preload()
                        ->multiple(),

                    Select::make('status_id')
                        ->label(__('post.status'))
                        ->required()
                        ->options([
                            self::ACTIVE => __('status.active'),
                            self::NON_ACTIVE => __('status.inactive'),
                        ])
                        ->selectablePlaceholder(false)
                        ->default(self::DEFAULT_VALUE_FOR_FIELDS),

                    Textarea::make('desc')
                        ->autofocus()
                        ->required()
                        ->default('Draft')
                        ->maxLength(self::DESC_MAX_LENGTH)
                        ->hint(
                            static fn(
                                $state,
                                $component
                            ) => __('post.left')
                                . self::getLastCharsLen($component->getMaxLength(), mb_strlen($state ?? ''))
                                . __('post.chars')
                        )
                        ->lazy()
                        ->live()
                        ->label(__('post.short_description'))
                        ->placeholder(__('post.placeholder.short_description')),

                    RichEditor::make('content')
                        ->label(__('post.content'))
                        ->required()
                        ->default('Draft')
                        ->placeholder(__('post.placeholder.content')),
                ]),

                Section::make(__('post.horizon_data.title'))
                    ->live()
                    ->label(__('post.horizon_data.title'))
                    ->relationship('horizonDataset')
                    ->hidden(static fn(Get $get) => PostTypeEnum::getAccessInvestIdea($get('post_type_id')))
                    ->schema([
                        Select::make('securitiesTicker')
                            ->hint(__('post.hint.shares'))
                            ->label(__('post.horizon_data.ticker'))
                            ->required()
                            ->live()
                            ->hidden(static fn(Get $get) => PostTypePaperEnum::getAccessShares($get('../type_paper_id')))
                            ->relationship('securitiesTicker', 'short_name', function (Select $component, $state): void {
                                if (filled($state)) {
                                    return;
                                }

                                $relationship = $component->getRelationship();

                                $relatedModels = $relationship->getResults();

                                $component->state(
                                    $relatedModels
                                        ->pluck($relationship->getRelatedKeyName())
                                        ->map(static fn($key): string => strval($key))
                                        ->toArray(),
                                );
                            })
                            ->preload()
                            ->multiple(),

                        Select::make('securitiesIsin')
                            ->label(__('post.horizon_data.isin'))
                            ->hint(__('post.hint.obligations'))
                            ->required()
                            ->live()
                            ->hidden(static fn(Get $get) => PostTypePaperEnum::getAccessObligations($get('../type_paper_id')))
                            ->relationship('securitiesIsin', 'code', function (Select $component, $state): void {
                                if (filled($state)) {
                                    return;
                                }

                                $relationship = $component->getRelationship();

                                $relatedModels = $relationship->getResults();

                                $component->state(
                                    $relatedModels
                                        ->pluck($relationship->getRelatedKeyName())
                                        ->map(static fn($key): string => strval($key))
                                        ->toArray(),
                                );
                            })
                            ->multiple()
                            ->preload(),

                        Select::make('country_id')
                            ->required()
                            ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                            ->label(__('post.horizon_data.country'))
                            ->relationship('country', 'title'),

                        TextInput::make('currentPrice')
                            ->required()
                            ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                            ->rule('numeric')
                            ->label(__('post.horizon_data.current_price')),

                        TextInput::make('potential')
                            ->required()
                            ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                            ->rule('numeric')
                            ->label(__('post.horizon_data.potential')),

                        Select::make('recommend')
                            ->required()
                            ->default(static fn(): string => HorizonRecommendEnum::getDefaultRecommendation())
                            ->options(static fn(): array => HorizonRecommendEnum::getRecommendations())
                            ->selectablePlaceholder(false)
                            ->label(__('post.horizon_data.recommendation')),

                        Select::make('risk')
                            ->required()
                            ->default(static fn(): string => HorizonRiskEnum::getDefaultRisk())
                            ->options(static fn(): array => HorizonRiskEnum::getRisks())
                            ->selectablePlaceholder(false)
                            ->label(__('post.horizon_data.risk')),

                        TextInput::make('openPrice')
                            ->required()
                            ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                            ->rule('numeric')
                            ->label(__('post.horizon_data.open_price')),

                        TextInput::make('targetPrice')
                            ->required()
                            ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                            ->rule('numeric')
                            ->label(__('post.horizon_data.target_price')),

                        TextInput::make('analyzePrice')
                            ->required()
                            ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                            ->rule('numeric')
                            ->label(__('post.horizon_data.analyze_price')),

                        Select::make('sector_id')
                            ->required()
                            ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                            ->relationship('sector', 'title')
                            ->label(__('post.horizon_data.sector')),
                    ]),

                Section::make(__('post.horizon_data.title'))
                    ->live()
                    ->relationship('horizonDataset')
                    ->hidden(fn(Get $get) => PostTypeEnum::getAccessNews($get('post_type_id')))
                    ->schema([
                        Select::make('ticker_id')
                            ->label(__('post.horizon_data.ticker'))
                            ->live()
                            ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                            ->hint(__('post.hint.shares'))
                            ->required()
                            ->hidden(static fn(Get $get) => PostTypePaperEnum::getAccessShares($get('../type_paper_id')))
                            ->relationship('ticker', 'short_name'),

                        Select::make('isin_id')
                            ->required()
                            ->live()
                            ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                            ->label(__('post.horizon_data.isin'))
                            ->hint(__('post.hint.obligations'))
                            ->hidden(static fn(Get $get) => PostTypePaperEnum::getAccessObligations($get('../type_paper_id')))
                            ->relationship('isin', 'code'),

                        Select::make('country_id')
                            ->required()
                            ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                            ->label('Country')
                            ->relationship('country', 'title'),

                        Select::make('sector_id')
                            ->required()
                            ->default(self::DEFAULT_VALUE_FOR_FIELDS)
                            ->relationship('sector', 'title')
                            ->label('Sector'),
                    ]),

                FileUpload::make('attachment')
//                    ->saveRelationshipsUsing(function (Model $record, $state) {
//                        app()->make(FileService::class)->upload(
//                            $state,
//                            $record->id,
//                        );
//                    })
                    ->downloadable()
                    ->directory('/posts/documents')
                    ->visibility('public')
                    ->maxSize(FileUploadIntEnum::DOCUMENT_MAX_SIZE->value)
                    ->storeFileNamesIn('attachment_file_names')
                    ->acceptedFileTypes(['application/pdf'])
                    ->label(__('post.files')),
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
                TextColumn::make('id')
                    ->label(__('post.id'))
                    ->sortable(),

                TextColumn::make('title')
                    ->label(__('post.title'))
                    ->searchable(),

                TextColumn::make('author.name')
                    ->label(__('post.author'))
                    ->url(
                        static fn(Post $post): string => UserResource::getUrl(
                            'edit',
                            [
                                'record' => $post->author_id,
                            ],
                        ),
                    )
                    ->searchable(),

                TextColumn::make('category.title')
                    ->label(__('post.category'))
                    ->url(
                        static fn(Post $post): string => CategoryResource::getUrl(
                            'edit',
                            [
                                'record' => $post->category_id,
                            ],
                        ),
                    )
                    ->searchable(),

                TextColumn::make('horizonDataset.country.title')
                    ->label(__('post.horizon_data.country'))
                    ->url(
                        static fn(Post $post): string => CountryResource::getUrl(
                            'index',
                            [
                                'record' => $post->horizonDataset?->country_id,
                            ],
                        ),
                    )
                    ->searchable(),

                TextColumn::make('postType.title')
                    ->badge()
                    ->label(__('post.type')),

                TextColumn::make('horizonDataset.sector.title')
                    ->badge()
                    ->label(__('post.horizon_data.sector')),

                TextColumn::make('horizonDataset.recommend')
                    ->badge()
                    ->sortable()
                    ->searchable()
                    ->label(__('post.horizon_data.recommendation'))
                    ->formatStateUsing(
                        fn(Post $post) => $post->post_type_id === PostTypeEnum::NEWS->value
                            ? null
                            : $post->horizonDataset?->recommend,
                    ),

                TextColumn::make('typePaper.title')
                    ->label(__('post.paper_type'))
                    ->url(
                        static fn(Post $post): string => TypePaperResource::getUrl(
                            'index',
                            [
                                'record' => $post->type_paper_id,
                            ],
                        ),
                    )
                    ->badge()
                    ->searchable(),

                TextColumn::make('tags.title')
                    ->label(__('post.tag'))
                    ->default('None')
                    ->badge()
                    ->searchable(),

                ToggleColumn::make('status_id')
                    ->state(
                        static fn(Post $post): bool => $post->status_id === self::ACTIVE,
                    )
                    ->updateStateUsing(
                        function ($state, $record) {
                            $record->status_id = $state ? self::ACTIVE : self::NON_ACTIVE;

                            if ($record->isDirty('status_id')) {
                                $record->save();
                            }

                            return $state;
                        },
                    )
                    ->label(__('post.status')),

                TextColumn::make('published_at')
                    ->label(__('post.published'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('expired_at')
                    ->label(__('post.expired'))
                    ->dateTime()
                    ->sortable(),

            ])
            ->filters([
                SelectFilter::make('author_id')
                    ->label(__('filters.author'))
                    ->options(self::getUsersNamesMap()),

                SelectFilter::make('post_type_id')
                    ->label(__('filters.post_type'))
                    ->options([
                        PostTypeEnum::INVEST_IDEA->value => __('post_type.invest_idea'),
                        PostTypeEnum::NEWS->value => __('post_type.news'),
                    ]),

                SelectFilter::make('type_paper_id')
                    ->label(__('filters.paper_type'))
                    ->relationship('typePaper', 'title'),

                SelectFilter::make('status_id')
                    ->label(__('filters.status'))
                    ->options([
                        self::ACTIVE => __('status.active'),
                        self::NON_ACTIVE => __('status.inactive'),
                    ]),

                SelectFilter::make('category_id')
                    ->label(__('filters.category'))
                    ->relationship('category', 'title'),

                SelectFilter::make('subcategory_id')
                    ->label(__('filters.subcategory'))
                    ->options(fn() => self::getAllSubcategories()),

                SelectFilter::make('country_id')
                    ->label(__('filters.country'))
                    ->relationship('horizonDataset.country', 'title'),

                SelectFilter::make('sector_id')
                    ->label(__('filters.sector'))
                    ->relationship('horizonDataset.sector', 'title'),

                SelectFilter::make('isin_id')
                    ->label(__('filters.isin'))
                    ->preload()
                    ->multiple()
                    ->relationship('horizonDataset.isin', 'code'),

                SelectFilter::make('ticker_id')
                    ->label(__('filters.ticker'))
                    ->preload()
                    ->multiple()
                    ->relationship('horizonDataset.ticker', 'short_name'),

                Filter::make('created_from')
                    ->form([
                        DatePicker::make('created_from')
                            ->label(__('filters.published')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                static fn(Builder $query, string $date): Builder => $query
                                    ->whereDate(
                                        'created_at',
                                        '>=',
                                        $date,
                                    ),
                            );
                    }),

                Filter::make('created_until')
                    ->form([
                        DatePicker::make('created_until')
                            ->label(__('filters.expired')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_until'],
                                static fn(Builder $query, $date): Builder => $query
                                    ->whereDate(
                                        'created_at',
                                        '<=',
                                        $date,
                                    ),
                            );
                    }),

                SelectFilter::make('tags')
                    ->label(__('filters.tag'))
                    ->multiple()
                    ->preload()
                    ->relationship('tags', 'title'),
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(6)
            ->actions([
                ViewAction::make(),
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
     * Get relations for resource.
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * Get pages for resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }

    /**
     * Get subcategories map-list. With id as key and title as value.
     *
     * @param int|string|null $parent_id The parent category id.
     * @return mixed
     */
    private static function getSubCategoriesMap(int|string|null $parent_id): mixed
    {
        if (!is_numeric($parent_id)) {
            return [];
        }

        return Category::where('parent_id', $parent_id)
            ->get()
            ->mapWithKeys(
                static fn(Category $category): array => [
                    $category->id => $category->title,
                ]
            )
            ->all();
    }

    /**
     * Get all subcategories.
     *
     * @return mixed
     */
    private static function getAllSubcategories(): mixed
    {
        return Category::whereNotNull('parent_id')
            ->get()
            ->mapWithKeys(
                static fn(Category $category): array => [
                    $category->id => $category->title,
                ]
            )
            ->all();
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('menu.post');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('menu.post');
    }

    /**
     * Get the displayable plural label of the resource.
     *
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return __('menu.post');
    }

    /**
     * Get length of the last chars.
     *
     * @param int $maxLen
     * @param int $stateLen
     * @return int
     */
    private static function getLastCharsLen(int $maxLen, int $stateLen): int
    {
        return $maxLen - $stateLen;
    }
}
