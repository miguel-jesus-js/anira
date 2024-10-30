<?php

namespace App\Repositories\TypeEmployee;

use App\Interfaces\TypeEmployee\TypeEmployeeInterface;
use App\Models\TypeEmployee;

class TypeEmployeeRepository implements TypeEmployeeInterface
{
    public function create(array $data)
    {
        // TODO: Implement create() method.
        return TypeEmployee::create($data);
    }
    public function all()
    {
        // TODO: Implement all() method.
        return TypeEmployee::all();
    }
    public function find(int $id)
    {
        // TODO: Implement find() method.
        return TypeEmployee::find($id);
    }
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
        $user = TypeEmployee::findOrFail($id);
        return $user->update($data);
    }
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
        $user = TypeEmployee::findOrFail($id);
        return $user->delete();
    }
    public function filter(array $filters, $perPage = 10)
    {
        $query = TypeEmployee::query();
        return $query->paginate($perPage);
    }
}
