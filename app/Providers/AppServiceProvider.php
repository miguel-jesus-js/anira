<?php

namespace App\Providers;

use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Contracts\TypeCustomerRepositoryInterface;
use App\Repositories\Contracts\TypeEmployeeRepositoryInterface;
use App\Repositories\Contracts\TypeTableRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\Table\TableRepository;
use App\Repositories\TypeCustomer\TypeCustomerRepository;
use App\Repositories\TypeEmployee\TypeEmployeeRepository;
use App\Repositories\TypeTable\TypeTableRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Repositories\Contracts\PeopleRepositoryInterface;
use App\Repositories\Addresses\AddressRepository;
use App\Repositories\People\PeopleRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(TypeEmployeeRepositoryInterface::class, TypeEmployeeRepository::class);
        $this->app->bind(TypeCustomerRepositoryInterface::class, TypeCustomerRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(PeopleRepositoryInterface::class, PeopleRepository::class);
        $this->app->bind(TypeTableRepositoryInterface::class, TypeTableRepository::class);
        $this->app->bind(TableRepositoryInterface::class, TableRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
