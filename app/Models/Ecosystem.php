<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecosystem extends Model
{
    use HasFactory;

    /** @inheritdoc */
    protected $table = 'ecosystem';

    /** @inheritdoc */
    protected $guarded = [
        'id',
    ];

    /** @inheritdoc */
    protected $fillable = [
        'website',
        'img',
    ];
}
