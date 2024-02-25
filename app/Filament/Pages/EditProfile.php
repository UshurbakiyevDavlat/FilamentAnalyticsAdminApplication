<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\FileUploadIntEnum;
use App\Exceptions\AuthModelShouldBeEloquentException;
use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $editProfileForm Edit profile form
 */
class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    /**
     * @var string $view The view
     */
    protected static string $view = 'filament.pages.edit-profile';

    /**
     * @var bool $shouldRegisterNavigation Whether to register the navigation
     */
    protected static bool $shouldRegisterNavigation = false;

    /**
     * @var array|null $profileData Profile data
     */
    public ?array $profileData = [];

    /**
     * @var array|null $passwordData Password data
     */
    public ?array $passwordData = [];

    /**
     * Mount the page
     *
     * @throws Exception
     * @return void
     */
    public function mount(): void
    {
        $this->fillForms();
    }

    /**
     * Get the forms
     *
     * @return string[]
     */
    protected function getForms(): array
    {
        return ['editProfileForm'];
    }

    /**
     * Edit profile form
     *
     * @param Form $form
     * @return Form
     * @throws AuthModelShouldBeEloquentException
     */
    public function editProfileForm(Form $form): Form
    {
        return $form->schema([
            Section::make(__('profile.label'))
                ->description(__('profile.desc'))
                ->schema([
                    TextInput::make('name')
                        ->label(__('user.name'))
                        ->disabled()
                        ->required(),

                    TextInput::make('email')
                        ->label(__('user.email'))
                        ->email()
                        ->disabled()
                        ->required(),

                    FileUpload::make('avatar_url')
                        ->label(__('user.avatar'))
                        ->directory('users/avatars')
                        ->downloadable()
                        ->visibility('public')
                        ->image()
                        ->maxSize(FileUploadIntEnum::IMAGE_MAX_SIZE->value),
                ]),
        ])
            ->model($this->getUser())
            ->statePath('profileData');
    }

    /**
     * Get the update profile form actions
     *
     * @return array
     */
    protected function getUpdateProfileFormActions(): array
    {
        return [
            Action::make('updateProfileAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editProfileForm'),
        ];
    }

    /**
     * Update the profile
     *
     * @throws AuthModelShouldBeEloquentException
     * @return void
     */
    public function updateProfile(): void
    {
        $data = $this->editProfileForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        $this->sendSuccessNotification();
    }

    /**
     * Handle the record update
     *
     * @param Model $record The record
     * @param array $data The data
     * @return Model
     */
    private function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        return $record;
    }

    /**
     * Get the user
     *
     * @throws AuthModelShouldBeEloquentException
     * @return Authenticatable|Model
     */
    protected function getUser(): Authenticatable|Model
    {
        $user = Filament::auth()->user();

        if (!$user instanceof Model) {
            throw new AuthModelShouldBeEloquentException();
        }

        return $user;
    }

    /**
     * Fill the forms
     *
     * @throws Exception
     * @return void
     */
    protected function fillForms(): void
    {
        $this->editProfileForm->fill($this->getUser()->attributesToArray());
    }

    /**
     * Get the title of the page
     *
     * @return string|Htmlable
     */
    public function getTitle(): string|Htmlable
    {
        return __('profile.edit.title');
    }

    /**
     * Send the success notification
     *
     * @return void
     */
    private function sendSuccessNotification(): void
    {
        Notification::make()
            ->success()
            ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
            ->send();
    }
}
