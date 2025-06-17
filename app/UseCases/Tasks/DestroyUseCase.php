<?php

namespace App\UseCases\Tasks;

use App\Models\Task;
use Labelgrup\LaravelUtilities\Core\UseCases\UseCase;
use Symfony\Component\HttpFoundation\Response;

class DestroyUseCase extends UseCase
{
    public int $success_status_code = Response::HTTP_NO_CONTENT;

    public function __construct(
        protected Task $task
    ) {
    }

    public function action(): void
    {
        $this->task->delete();
    }
}
