<?php

namespace App\Providers;

use App\Interfaces\Employee\EmployeeInterface;
use App\Interfaces\People\PeopleInterface;
use App\Interfaces\TypeEmployee\TypeEmployeeInterface;
use App\Interfaces\User\UserInterface;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\People\PeopleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(PeopleInterface::class, PeopleRepository::class);
        $this->app->bind(EmployeeInterface::class, EmployeeRepository::class);
        $this->app->bind(TypeEmployeeInterface::class, TypeEmployeeInterface::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
