<?php

namespace App\Providers;

use App\Interfaces\AddressesInterface;
use App\Interfaces\BaseRepositoryInterface;
use App\Repositories\Addresses\AddressesRepository;
use App\Repositories\TypeCustomer\TypeCustomerRepository;
use App\Repositories\TypeEmployee\TypeEmployeeRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, TypeCustomerRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, TypeEmployeeRepository::class);
        $this->app->bind(AddressesInterface::class, AddressesRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
