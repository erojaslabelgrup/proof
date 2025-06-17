<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    public const STATUS_TODO = 'todo';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_TESTING = 'testing';
    public const STATUS_DONE = 'done';
    public const STATUS_CANCELED = 'canceled';

    public const STATUSES = [
        self::STATUS_TODO,
        self::STATUS_IN_PROGRESS,
        self::STATUS_TESTING,
        self::STATUS_DONE,
        self::STATUS_CANCELED,
    ];

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'status',
        'description',
    ];

    protected $with = [
        'user'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function watchers(): MorphMany
    {
        return $this->morphMany(Watcher::class, 'watchable')->with('user');
    }
}
