<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileType extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** {@inheritDoc} */
    protected $guarded = [
        'id',
    ];

    /** {@inheritDoc} */
    protected $fillable = [
        'title',
        'extension',
        'mime_type',
        'icon',
    ];
}
