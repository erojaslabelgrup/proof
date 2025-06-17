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
    public int $success_status_code = Response::HTTP_CREATED;

    public function __construct(
        User $user,
        Project|Task $item
    ) {
    }

	/**
	* Methods inherited from UseCase
	*
	* handle(): Method to called to get UseCaseResponse
	* perform(): Method to call $this->validate() (if implemented) and if no throw exception, call & return $this->action()
	*/
	public function action()
	{
		// TODO Implement action
	}

	public function validate(): void
	{
        // TODO Implement validation
	}
}
