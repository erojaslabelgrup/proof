<?php

namespace App\UseCases\Projects;

use App\Models\Project;
use Labelgrup\LaravelUtilities\Core\UseCases\UseCase;
use Symfony\Component\HttpFoundation\Response;

class DestroyUseCase extends UseCase
{
    public int $success_status_code = Response::HTTP_NO_CONTENT;

    public function __construct(
        protected Project $project
    ) {
    }

    public function action(): void
    {
        $this->project->delete();
    }
}
