<?php

namespace App\UseCases\Tasks;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Labelgrup\LaravelUtilities\Core\UseCases\UseCase;
use Labelgrup\LaravelUtilities\Core\UseCases\WithValidateInterface;
use Symfony\Component\HttpFoundation\Response;

class StoreUseCase extends UseCase implements WithValidateInterface
{
    public int $success_status_code = Response::HTTP_CREATED;

    public function __construct(
        protected Project $project,
        protected User $user,
        protected string $name,
        protected string $status,
        protected ?string $description = null
    ) {
    }

    public function action(): Task
    {
        return Task::create([
            'project_id' => $this->project->id,
            'user_id' => $this->user->id,
            'title' => $this->name,
            'status' => $this->status,
            'description' => $this->description,
        ]);
    }

    public function validate(): void
    {
        if (!in_array($this->status, Project::STATUSES)) {
            throw new \RuntimeException('Invalid task status', Response::HTTP_BAD_REQUEST);
        }
    }
}
