<?php

namespace App\UseCases\Projects;

use App\Models\Project;
use Labelgrup\LaravelUtilities\Core\UseCases\UseCase;
use Labelgrup\LaravelUtilities\Core\UseCases\WithValidateInterface;
use Symfony\Component\HttpFoundation\Response;

class UpdateUseCase extends UseCase implements WithValidateInterface
{
    public function __construct(
        protected Project $project,
        protected string $identifier,
        protected string $name,
        protected string $status,
        protected ?string $description = null
    ) {
    }

    public function action(): Project
    {
        $this->project->identifier = $this->identifier;
        $this->project->name = $this->name;
        $this->project->status = $this->status;
        $this->project->description = $this->description;
        $this->project->save();
        $this->project->refresh();

        return $this->project;
    }

    public function validate(): void
    {
        if (Project::where('identifier', $this->identifier)->where('id', '!=', $this->project->id)->exists()) {
            throw new \RuntimeException('Project with this identifier already exists', Response::HTTP_BAD_REQUEST);
        }

        if (!in_array($this->status, Project::STATUSES)) {
            throw new \RuntimeException('Invalid project status', Response::HTTP_BAD_REQUEST);
        }
    }
}
