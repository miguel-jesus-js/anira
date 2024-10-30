<?php

namespace App\Repositories\Employee;

use App\Interfaces\Employee\EmployeeInterface;
use App\Models\Employee;

class EmployeeRepository implements EmployeeInterface
{
    public function create(array $data)
    {
        // TODO: Implement create() method.
        return Employee::create($data);
    }
    public function all(array $relations = [])
    {
        // TODO: Implement all() method.
        return Employee::with($relations)->get();
    }
    public function find(int $id)
    {
        // TODO: Implement find() method.
        return Employee::find($id);
    }
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
        $user = Employee::findOrFail($id);
        return $user->update($data);
    }
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
        $user = Employee::findOrFail($id);
        return $user->delete();
    }
    public function filter(array $filters, array $relations = [], int $perPage = 10)
    {
        $query = Employee::query();
        $query->with($relations)->orderBy('employees.id', 'DESC');
        return $query->paginate($perPage);
    }
}
