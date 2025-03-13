<?php

namespace App\Repositories\Contracts;

interface AddressesRepositoryInterface extends BaseRepositoryInterface
{
    public function existAddressWithLocation(Float $latitude, Float $longitude);
}
