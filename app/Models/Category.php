<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $title
 */
class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** {@inheritDoc} */
    protected $guarded = ['id'];

    /** {@inheritDoc} */
    protected $fillable = [
        'title',
        'order',
        'parent_id',
        'status_id',
        'description',
        'img',
    ];

    /**
     * Get the status that owns the Category.
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get the posts for the Category.
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the parent that owns the Category.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    /**
     * Get all the children for the Category.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    /**
     * Register events for model's lifecycle
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        self::saving(function ($category) {
            $category->slug = Str::slug($category->getAttribute('title') . '-' . $category->getAttribute('id'));
        });
    }

    /**
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class);
    }
}
