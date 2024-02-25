<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    /**
     * The displayable name of the resource being managed.
     *
     * @var string|null
     */
    protected static ?string $model = User::class;

    /**
     * Navigation icon for resource.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->label(__('user.email'))
                    ->required()
                    ->email()
                    ->disabled()
                    ->unique(ignorable: fn($record) => $record),

                TextInput::make('job_title')
                    ->label(__('user.job_title'))
                    ->disabled(),

                Select::make('roles')
                    ->label(__('user.role'))
                    ->relationship('roles', 'name')
                    ->options(function () {
                        return collect(__('role'))->mapWithKeys(function ($label, $value) {
                            return [$value => $label];
                        })->toArray();
                    }),
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
                ImageColumn::make('avatar_url')->label(__('profile.avatar')),

                TextColumn::make('name')
                    ->label(__('user.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label(__('user.email'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('job_title')
                    ->label(__('user.job_title'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('roles.name')
                    ->label(__('user.role'))
                    ->default('employee')
                    ->formatStateUsing(
                        fn(string $state): string => __(
                            'role.'
                            . Role::where('name', $state)->first()?->id,
                        ),
                    )
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('user.created_at'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    /**
     * Get the resource name for the resource.
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
            'index' => Pages\ListUsers::route('/'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('menu.user');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('menu.user');
    }

    /**
     * Get the displayable plural label of the resource.
     *
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return __('menu.user');
    }
}
