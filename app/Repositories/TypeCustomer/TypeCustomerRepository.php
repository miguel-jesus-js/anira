<?php

namespace App\Repositories\TypeCustomer;

use App\Models\TypeCustomer;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\TypeCustomerRepositoryInterface;

class TypeCustomerRepository extends BaseRepository implements TypeCustomerRepositoryInterface
{
    public function __construct(TypeCustomer $model)
    {
        parent::__construct($model);
    }

    protected function applyFilters($query, array $filters): void
    {
        if (!empty($filters['type_customer'])) {
            $query->where('type_customer', $filters['type_customer']);
        }
    }
}
