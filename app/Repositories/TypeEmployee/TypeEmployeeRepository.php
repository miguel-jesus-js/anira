<?php

namespace App\Repositories\TypeEmployee;

use App\Models\TypeEmployee;
use App\Repositories\BaseRepository;

class TypeEmployeeRepository extends BaseRepository
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
