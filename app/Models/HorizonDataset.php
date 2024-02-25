<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * HorizonDataset model.
 *
 * @package App\Models
 *
 * @property int $country_id
 */
class HorizonDataset extends Model
{
    use HasFactory;

    /** {@inheritDoc} */
    protected $guarded = ['id'];

    /** {@inheritDoc} */
    protected $table = 'post_horizon_dataset';

    /** {@inheritDoc} */
    protected $with = ['securitiesTicker', 'securitiesIsin'];

    /** {@inheritDoc} */
    protected $fillable = [
        'currentPrice',
        'openPrice',
        'targetPrice',
        'potential',
        'recommend',
        'analyzePrice',
        'horizon',
        'status',
        'risk',
        'ticker_id',
        'country_id',
        'isin_id',
        'sector_id',
    ];

    /**
     * Ticker`s relation.
     *
     * @return BelongsTo
     */
    public function ticker(): BelongsTo
    {
        return $this->belongsTo(Ticker::class);
    }

    /**
     * Security's ticker relation.
     *
     * @return MorphToMany
     */
    public function securitiesTicker(): MorphToMany
    {
        return $this->morphedByMany(
            Ticker::class,
            'security',
            'horizon_dataset_has_securities',
            'horizon_dataset_id',
            'security_id',
            'id',
        )
            ->withTimestamps();
    }

    /**
     * Security's isin relation.
     *
     * @return MorphToMany
     */
    public function securitiesIsin(): MorphToMany
    {
        return $this->morphedByMany(
            Isin::class,
            'security',
            'horizon_dataset_has_securities',
            'horizon_dataset_id',
            'security_id',
            'id',
        )
            ->withTimestamps();
    }

    /**
     * Country's relation.
     *
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Isin's relation.
     *
     * @return BelongsTo
     */
    public function isin(): BelongsTo
    {
        return $this->belongsTo(Isin::class);
    }

    /**
     * Sector's relation.
     *
     * @return BelongsTo
     */
    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }

    /**
     * Post's relation.
     *
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
