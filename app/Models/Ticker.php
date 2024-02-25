<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticker extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** {@inheritDoc} */
    protected $guarded = ['id'];

    /** {@inheritDoc} */
    protected $table = 'tickers';

    /** {@inheritDoc} */
    protected $fillable = [
        'full_name',
        'short_name',
        'is_active',
        'is_favorite',
    ];

    /**
     * Posts relationship
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(HorizonDataset::class);
    }

    /**
     * Security's relation.
     *
     * @return BelongsToMany
     */
    public function securities(): BelongsToMany
    {
        return $this->belongsToMany(
            HorizonDataset::class,
            'horizon_dataset_has_securities',
            'security_id',
            'horizon_dataset_id'
        );
    }
}
