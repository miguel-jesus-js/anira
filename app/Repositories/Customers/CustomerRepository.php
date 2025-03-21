<?php

namespace App\Repositories\Customers;

use App\Models\Customer;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
    }

    protected function applyFilters($query, array $filters): void
    {
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
    }
}
