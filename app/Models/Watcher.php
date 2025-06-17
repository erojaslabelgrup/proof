<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Watcher extends Model
{
    protected $fillable = [
        'user_id',
        'watchable_type',
        'watchable_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function watchable(): BelongsTo
    {
        return $this->morphTo();
    }
}
