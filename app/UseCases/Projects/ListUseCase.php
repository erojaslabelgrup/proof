<?php

namespace App\UseCases\Projects;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;
use Labelgrup\LaravelUtilities\Core\UseCases\UseCase;

class ListUseCase extends UseCase
{
    public function __construct(
        protected int $page = 1,
        protected int $per_page = 10
    ) {
    }

    public function action(): LengthAwarePaginator
    {
        return Project::query()->paginate($this->per_page, ['*'], 'page', $this->page);
    }
}
