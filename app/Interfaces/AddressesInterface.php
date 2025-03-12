<?php

namespace App\Interfaces;

interface AddressesInterface extends BaseRepositoryInterface
{
    public function existAddressWithLocation(Float $latitude, Float $longitude);
}
