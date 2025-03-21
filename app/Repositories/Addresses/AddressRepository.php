<?php

namespace App\Repositories\Addresses;

use App\Models\Address;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\AddressRepositoryInterface;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
    public function __construct(Address $address)
    {
       parent::__construct($address);
    }

    public function existAddressWithLocation(float $latitude, float $longitude): Address | null
    {
        return $this->model->where([['latitude', $latitude], ['longitude', $longitude]])->first();
    }

    protected function applyFilters($query, array $filters): void
    {

    }
}
