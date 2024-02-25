<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Isin extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @inheritdoc */
    protected $guarded = ['id'];

    /** @inheritdoc */
    protected $table = 'isins';

    /** @inheritdoc */
    protected $fillable = ['code', 'is_active', 'is_favorite'];

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
     * @return MorphToMany
     */
    public function securities(): MorphToMany
    {
        return $this->morphToMany(
            HorizonDataset::class,
            'security',
            'horizon_dataset_has_securities',
            'security_id',
            'horizon_dataset_id'
        );
    }
}
