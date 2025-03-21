<?php

namespace App\Repositories\TypeTable;

use App\Models\TypeTable;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\TypeTableRepositoryInterface;

class TypeTableRepository extends BaseRepository implements TypeTableRepositoryInterface
{
    public function __construct(TypeTable $typeTable)
    {
        parent::__construct($typeTable);
    }

    protected function applyFilters($query, array $filters): void
    {
        if (!empty($filters['type_table'])) {
            $query->where('type_table', $filters['type_table']);
        }
    }
}
