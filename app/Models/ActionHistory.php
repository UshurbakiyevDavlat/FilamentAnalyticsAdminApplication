<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActionHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** {@inheritDoc} */
    protected $guarded = ['id'];

    /** {@inheritDoc} */
    protected $fillable = [
        'action_id',
        'user_id',
        'actionable_id',
        'actionable_type',
    ];

    /**
     * Get the action that owns the ActionHistory.
     *
     * @return BelongsTo
     */
    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }

    /**
     * Get the user that owns the ActionHistory.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the actionable that the ActionHistory belongs to.
     *
     * @return MorphTo
     */
    public function actionable(): MorphTo
    {
        return $this->morphTo();
    }
}
