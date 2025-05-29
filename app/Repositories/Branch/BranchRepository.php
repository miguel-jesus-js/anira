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

    protected function applyFilters($query, array $filters): void
    {
        if(isset($filters['id']))
        {
            $query->id($filters['id']);
        }
        if(isset($filters['address_id']))
        {
            $query->addressByAddress($filters['address_id']);
        }
        if(isset($filters['employee_id']))
        {
            $query->mandated($filters['employee_id']);
        }
        if(isset($filters['email']))
        {
            $query->email($filters['email']);
        }
        if(isset($filters['phone_number']))
        {
            $query->phone($filters['phone_number']);
        }
        if(isset($filters['status']))
        {
            $query->status($filters['status']);
        }
    }
}
