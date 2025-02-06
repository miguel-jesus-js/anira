<?php

namespace App\Repositories\Customers;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CustomerRepository implements BaseRepositoryInterface
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
    public function create(array $data)
    {
        return $this->customer::create($data);
    }
    public function all(array $filters, array $relations, bool $paginate, int $perPage): LengthAwarePaginator|Collection
    {
        $query = $this->customer->newQuery();
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

    public function find(int $id, $relations = []): object
    {
        return $this->customer->find($id)->load($relations);

    }
    public function update(int $id, array $data)
    {
        $customer = $this->find($id);
        return $customer->update($data);
    }
    public function delete(int $id)
    {

    }
}
