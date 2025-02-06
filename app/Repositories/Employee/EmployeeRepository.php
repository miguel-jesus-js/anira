<?php

namespace App\Repositories\Employee;

use App\Interfaces\Employee\EmployeeInterface;
use App\Models\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository implements EmployeeInterface
{
    protected $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }
    public function create(array $data)
    {
        // TODO: Implement create() method.
        return Employee::create($data);
    }

    /**
     * @param array $filters
     * @param array $relations
     * @param bool $paginate
     * @param int $perPage
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters, array $relations, bool $paginate, int $perPage): LengthAwarePaginator|Collection
    {
        $query = $this->employee->newQuery();
        if(!empty($filters['first_name']))
        {
            $query->firstName($filters['first_name']);
        }
        if(!empty($filters['last_name']))
        {
            $query->lastName($filters['last_name']);
        }
        if(!empty($filters['email']))
        {
            $query->email($filters['email']);
        }
        if(!empty($filters['dni']))
        {
            $query->dni($filters['dni']);
        }
        if(!empty($filters['phone_number']))
        {
            $query->phone($filters['phone_number']);
        }
        if(!empty($filters['user_name']))
        {
            $query->userName($filters['user_name']);
        }
        if(!empty($filters['type_employee_id']))
        {
            $query->type($filters['type_employee_id']);
        }
        if(!empty($filters['status']))
        {
            $query->status($filters['status']);
        }
        $query->with($relations);
        if($paginate)
        {
            return $query->paginate($perPage);
        }
        return $query->get();
    }

    /**
     * @param int $id
     * @param array $relations
     * @return object
     */
    public function find(int $id, array $relations = []) : object
    {
        return $this->employee->find($id)->load($relations);
    }
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
        $employee = $this->find($id);
        return $employee->update($data);
    }
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
        $employee = $this->employee->find($id);
        return $employee->delete();
    }
    public function filter(array $filters, array $relations = [], int $perPage = 10)
    {
        $query = Employee::query();
        $query->with($relations)->orderBy('employees.id', 'DESC');
        if(isset($filters['email'])) {
            $query->filterByEmail($filters['email']);
        }
        return $query->paginate($perPage);
    }
}
