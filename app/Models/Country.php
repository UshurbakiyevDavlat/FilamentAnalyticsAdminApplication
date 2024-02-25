<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** {@inheritDoc} */
    protected $guarded = ['id'];

    /** {@inheritDoc} */
    protected $fillable = [
        'title',
        'img'
    ];

    /**
     * Get the posts for the Country.
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(HorizonDataset::class);
    }
}
