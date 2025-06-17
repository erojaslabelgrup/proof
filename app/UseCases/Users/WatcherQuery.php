<?php

namespace App\UseCases\Users;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Watcher;
use Illuminate\Contracts\Database\Eloquent\Builder;

trait WatcherQuery
{
    protected function queryFindWatcher(
        User $user,
        Project|Task $watchable
    ): Builder {
        return Watcher::where('user_id', $user->id)
            ->where('watchable_type', get_class($watchable))
            ->where('watchable_id', $watchable->id);
    }
}
