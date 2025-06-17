<?php

namespace App\UseCases\Projects;

use App\Models\Project;
use Labelgrup\LaravelUtilities\Core\UseCases\UseCase;
use Symfony\Component\HttpFoundation\Response;

class StoreUseCase extends UseCase
{
    public int $success_status_code = Response::HTTP_CREATED;

    public function __construct(
        public string $identifier,
        public string $name,
        public ?string $description = null
    ) {
    }

    public function action(): Project
    {
        return Project::create([
            'identifier' => $this->identifier,
            'name' => $this->name,
            'description' => $this->description
        ]);
    }
}
