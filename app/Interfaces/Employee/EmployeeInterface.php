<?php

namespace App\Interfaces\Employee;

interface EmployeeInterface
{
    public function create(array $data);
    public function all(array $filters, array $relations, bool $paginate, int $perPage);
    public function find(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
}
