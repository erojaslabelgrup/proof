<?php

namespace App\UseCases\Tasks;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Labelgrup\LaravelUtilities\Core\UseCases\UseCase;
use Labelgrup\LaravelUtilities\Core\UseCases\WithValidateInterface;
use Symfony\Component\HttpFoundation\Response;

class UpdateUseCase extends UseCase implements WithValidateInterface
{
    public function __construct(
        protected Task $task,
        protected Project $project,
        protected User $user,
        protected string $name,
        protected string $status,
        protected ?string $description = null
    ) {
    }

    public function action(): Task
    {
        $this->task->project_id = $this->project->id;
        $this->task->user_id = $this->user->id;
        $this->task->title = $this->name;
        $this->task->status = $this->status;
        $this->task->description = $this->description;
        $this->task->save();
        $this->task->refresh();

        return $this->task;
    }

    public function validate(): void
    {
        if (!in_array($this->status, Project::STATUSES)) {
            throw new \RuntimeException('Invalid task status', Response::HTTP_BAD_REQUEST);
        }
    }
}
