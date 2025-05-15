<?php

namespace App\Repositories\Contracts;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;

interface AddressRepositoryInterface extends BaseRepositoryInterface
{
    public function existAddressWithLocation(Float $latitude, Float $longitude);
    public function attachAddressToEntity(Model $entity, array $address);
}
