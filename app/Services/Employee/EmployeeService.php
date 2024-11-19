<?php

namespace App\Services\Employee;

use App\Repositories\Employee\EmployeeRepository;

class EmployeeService
{
    protected $employeeRepository;
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function getAllEmployees(array $filters, array $relations = [], int $perPage = 10)
    {
        return $this->employeeRepository->filter($filters, $relations, $perPage);
    }
    public function findEmployeeById(int $id, array $relations = [])
    {
        return $this->employeeRepository->find($id, $relations);
    }
}
