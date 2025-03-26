<?php

namespace App\Repositories\Table;

use App\Models\Table;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\TableRepositoryInterface;

class TableRepository extends BaseRepository implements TableRepositoryInterface
{
    public function __construct(Table $table)
    {
        parent::__construct($table);
    }

    public function applyFilters($query, array $filters)
    {
        if(!empty($filters['type_table_id']))
        {
            $query->typeTable($filters['type_table_id']);
        }
        if(!empty($filters['number']))
        {
            $query->number($filters['number']);
        }
        if(!empty($filters['name']))
        {
            $query->name($filters['name']);
        }
        if(!empty($filters['description']))
        {
            $query->description($filters['description']);
        }
        if(!empty($filters['capacity']))
        {
            $query->capacity($filters['capacity']);
        }
    }
}
