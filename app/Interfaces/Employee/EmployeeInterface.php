<?php

namespace App\Interfaces\Employee;

interface EmployeeInterface
{
    public function create(array $data);
    public function all(array $relations = []);
    public function find(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
}
