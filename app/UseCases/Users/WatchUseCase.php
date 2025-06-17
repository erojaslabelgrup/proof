<?php

namespace App\UseCases\Users;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Watcher;
use Labelgrup\LaravelUtilities\Core\UseCases\UseCase;
use Labelgrup\LaravelUtilities\Core\UseCases\WithValidateInterface;
use Symfony\Component\HttpFoundation\Response;

class WatchUseCase extends UseCase implements WithValidateInterface
{
    use WatcherQuery;

    public int $success_status_code = Response::HTTP_CREATED;

    public function __construct(
        protected User $user,
        protected Project|Task $watchable
    ) {
    }

	/**
	* Methods inherited from UseCase
	*
	* handle(): Method to called to get UseCaseResponse
	* perform(): Method to call $this->validate() (if implemented) and if no throw exception, call & return $this->action()
	*/
	public function action(): Watcher
	{
        return Watcher::create([
            'user_id' => $this->user->id,
            'watchable_type' => get_class($this->watchable),
            'watchable_id' => $this->watchable->id,
        ]);
	}

	public function validate(): void
	{
        if ($this->queryFindWatcher($this->user, $this->watchable)->exists()) {
            throw new \RuntimeException('User is already watching this item', Response::HTTP_BAD_REQUEST);
        }
	}
}
