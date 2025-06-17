<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Project extends Model
{
    public const STATUS_ANALYSIS = 'analysis';
    public const STATUS_PLANNING = 'planning';
    public const STATUS_EXECUTION = 'execution';
    public const STATUS_CLOSURE = 'closure';
    public const STATUS_CANCELED = 'canceled';

    public const STATUSES = [
        self::STATUS_ANALYSIS,
        self::STATUS_PLANNING,
        self::STATUS_EXECUTION,
        self::STATUS_CLOSURE,
        self::STATUS_CANCELED
    ];

    protected $fillable = [
        'identifier',
        'name',
        'description',
        'status'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function watchers(): MorphMany
    {
        return $this->morphMany(Watcher::class, 'watchable')->with('user');
    }
}
