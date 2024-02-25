<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostType extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @inheritdoc */
    protected $table = 'post_types';

    /** @inheritdoc */
    protected $guarded = ['id'];

    /** @inheritdoc */
    protected $fillable = [
        'title',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
