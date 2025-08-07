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
        if (isset($filters['id'])) {
            $query->id($filters['id']);
        }
        if (isset($filters['type_customer'])) {
            $query->typeCustomer($filters['type_customer']);
        }
        if (isset($filters['status'])) {
            $query->status($filters['status']);
        }
    }
}
