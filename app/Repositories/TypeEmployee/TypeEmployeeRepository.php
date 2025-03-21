<?php

namespace App\Repositories\TypeEmployee;

use App\Models\TypeEmployee;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\TypeEmployeeRepositoryInterface;

class TypeEmployeeRepository extends BaseRepository implements TypeEmployeeRepositoryInterface
{
    public function __construct(TypeEmployee $typeEmployee)
    {
        parent::__construct($typeEmployee);
    }

    protected function applyFilters($query, array $filters): void
    {
        if (!empty($filters['type_employee'])) {
            $query->where('type_employee', $filters['type_employee']);
        }
    }
}
