<?php

namespace App\Repositories\Branch;

use App\Models\Branch;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\BranchRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class BranchRepository extends BaseRepository implements BranchRepositoryInterface
{
    public function __construct(Branch $branch)
    {
        parent::__construct($branch);
    }

    /**
     * @throws Exception
     */
    public function attach(int $modelId, Branch|Model $model): void
    {
        $branch = $this->find($modelId);
        $branch->address()->attach($model);
    }

    /**
     * @throws Exception
     */
    public function detach(int $modelId, Branch|Model $model): void
    {
        $branch = $this->find($modelId);
        $branch->address()->detach($model);
    }
}
