<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * */
class Car extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'make',
        'model',
        'year',
        'trip_count',
        'trip_miles',
        'user_id',
    ];

    protected $casts = [
        'year' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
