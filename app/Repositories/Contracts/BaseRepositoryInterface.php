<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function create(array $data);
    public function all(array $filters, array $relations, bool $paginate, int $perPage);
    public function find(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function attach(int $modelId, Model $model);
    public function detach(int $modelId, Model $model);
}
