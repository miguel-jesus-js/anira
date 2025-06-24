<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\EmployeeRepositoryInterface;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    public function __construct(Employee $employee)
    {
        parent::__construct($employee);
    }

    protected function applyFilters($query, array $filters): void
    {
        if(isset($filters['id']))
        {
            $query->id($filters['id']);
        }
        if(isset($filters['first_name']))
        {
            $query->firstName($filters['first_name']);
        }
        if(isset($filters['last_name']))
        {
            $query->lastName($filters['last_name']);
        }
        if(isset($filters['email']))
        {
            $query->email($filters['email']);
        }
        if(isset($filters['dni']))
        {
            $query->dni($filters['dni']);
        }
        if(isset($filters['phone_number']))
        {
            $query->phone($filters['phone_number']);
        }
        if(isset($filters['user_name']))
        {
            $query->userName($filters['user_name']);
        }
        if(isset($filters['type_employee_id']))
        {
            $query->type($filters['type_employee_id']);
        }
        if(isset($filters['status']))
        {
            $query->status($filters['status']);
        }
    }
}
