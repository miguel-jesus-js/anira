<?php

namespace App\Repositories\Contracts;

interface AddressRepositoryInterface extends BaseRepositoryInterface
{
    public function existAddressWithLocation(Float $latitude, Float $longitude);
}
