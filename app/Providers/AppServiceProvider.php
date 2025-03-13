<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\AddressesRepositoryInterface;
use App\Repositories\Contracts\PeopleRepositoryInterface;
use App\Repositories\Addresses\AddressesRepository;
use App\Repositories\People\PeopleRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AddressesRepositoryInterface::class, AddressesRepository::class);
        $this->app->bind(PeopleRepositoryInterface::class, PeopleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
