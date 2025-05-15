<?php

namespace App\Repositories\Addresses;

use App\Models\Address;
use App\Models\Branch;
use App\Models\People;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\AddressRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * @param Model $entity
     * @param array $address
     * @return void
     * @throws \Exception
     */
    public function attachAddressToEntity(Model $entity, array $address): void
    {
        $existAddress = $this->existAddressWithLocation($address['latitude'], $address['longitude']);
        if(is_null($existAddress))
        {
            $newAddress = $this->create($address);

        }else{
            $newAddress = $existAddress;
        }

        if ($entity instanceof Branch) {
            $entity->address()->associate($existAddress)->save();
            return;
        }
        if ($entity instanceof People) {
            $entity->addresses()->attach($newAddress);
            return;
        }
    }

    protected function applyFilters($query, array $filters): void
    {

    }
}
