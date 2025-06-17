<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'name',
        'description',
        'status'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
