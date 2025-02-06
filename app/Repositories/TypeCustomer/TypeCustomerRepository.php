<?php

namespace App\Repositories\TypeCustomer;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\TypeCustomer;

class TypeCustomerRepository implements BaseRepositoryInterface
{
    protected $typeCustomer;

    public function __construct(TypeCustomer $typeCustomer)
    {
        $this->typeCustomer = $typeCustomer;
    }
    public function create(array $data)
    {
        // TODO: Implement create() method.
        return $this->typeCustomer::create($data);
    }
    public function all(array $filters, array $relations, bool $paginate, int $perPage)
    {
        // TODO: Implement all() method.
        return $this->typeCustomer::all();
    }
    public function find(int $id)
    {
        // TODO: Implement find() method.
        return $this->typeCustomer::find($id);
    }
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
        $user = $this->typeCustomer::findOrFail($id);
        return $user->update($data);
    }
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
        $user = $this->typeCustomer::findOrFail($id);
        return $user->delete();
    }
}
