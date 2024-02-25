<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Althinect\FilamentSpatieRolesPermissions\Concerns\HasSuperAdmin;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\EncryptedRow;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property int $id
 * @property ?string $avatar_url
 * @property ?string $job_title
 * @property string $name
 * @property string $email
 */
class User extends Authenticatable implements FilamentUser, JWTSubject, CipherSweetEncrypted, HasAvatar
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use UsesCipherSweet;
    use HasSuperAdmin;

    /** {@inheritDoc} */
    protected $fillable = [
        'name',
        'email',
        'avatar_url',
        'job_title',
    ];

    /** {@inheritDoc} */
    protected $hidden = [
        'remember_token',
    ];

    /** {@inheritDoc} */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the panel that belongs to the user.
     *
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@ffin.kz');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Get the custom claims array to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * Configuration of Cipher sweet package encryption
     *
     * @param EncryptedRow $encryptedRow
     * @return void
     */
    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addField('email')
            ->addField('name')
            ->addBlindIndex(
                'email',
                new BlindIndex('email_index'),
            )
            ->addBlindIndex(
                'name',
                new BlindIndex('name_index'),
            );
    }

    /**
     * Get the posts for the user.
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(
            Post::class,
            'author_id',
        );
    }

    /**
     * Get the user's avatar URL for Filament.
     *
     * @return string|null
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::disk('public')->url($this->avatar_url) : null;
    }
}
