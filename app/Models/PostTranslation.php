<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTranslation extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** {@inheritDoc} */
    protected $table = 'post_translations';

    /** {@inheritDoc} */
    protected $fillable = [
        'title',
        'content',
        'desc',
        'post_id',
        'locale_id',
    ];

    /**
     * Get the post that owns the PostTranslation.
     *
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the locale that owns the PostTranslation.
     *
     * @return BelongsTo
     */
    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }
}
