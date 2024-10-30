<?php

namespace App\Services\TypeEmployeeService;

use App\Repositories\TypeEmployee\TypeEmployeeRepository;

class TypeEmployeeService
{
    protected $typeEmployeeRepository;

    public function __construct(TypeEmployeeRepository $typeEmployeeRepository)
    {
        $this->typeEmployeeRepository = $typeEmployeeRepository;
    }
    public function createTypeEmployee(array $data)
    {
        return $this->typeEmployeeRepository->create($data);
    }
    public function getAllTypeEmployee(array $filters, int $perPage = 10)
    {
        return $this->typeEmployeeRepository->filter($filters, $perPage);
    }

    public function findTypeEmployeeById(int $id)
    {
        return $this->typeEmployeeRepository->find($id);
    }
    public function updateTypeEmployee(int $id, array $data)
    {
        return $this->typeEmployeeRepository->update($id, $data);
    }
    public function deleteTypeEmployee(int $id)
    {
        return $this->typeEmployeeRepository->delete($id);
    }
}
