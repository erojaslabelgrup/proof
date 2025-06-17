<?php

namespace App\UseCases\Tasks;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;
use Labelgrup\LaravelUtilities\Core\UseCases\UseCase;

class ListUseCase extends UseCase
{
    public function __construct(
        protected ?int $filter_project_id = null,
        protected ?int $filter_user_id = null,
        protected ?string $filter_status = null,
        protected int $page = 1,
        protected int $per_page = 10
    ) {}

    public function action(): LengthAwarePaginator
    {
        $query = Task::query();

        if ($this->filter_project_id) {
            $query->where('project_id', $this->filter_project_id);
        }

        if ($this->filter_user_id) {
            $query->where('user_id', $this->filter_user_id);
        }

        if ($this->filter_status) {
            $query->where('status', $this->filter_status);
        }

        return $query->paginate($this->per_page, ['*'], 'page', $this->page);
    }
}
