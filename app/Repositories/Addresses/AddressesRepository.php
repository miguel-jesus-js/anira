<?php

namespace App\Repositories\Addresses;

use App\Interfaces\Addresses\AddressesInterface;
use App\Models\Address;

class AddressesRepository implements AddressesInterface
{
    protected $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }
    public function create(array $data)
    {
        // TODO: Implement create() method.
        return Address::create($data);
    }
    public function all(array $relations = [])
    {
        // TODO: Implement all() method.
        return Address::with($relations)->get();
    }
    public function find(int $id, array $relations = [])
    {
        // TODO: Implement find() method.
        return Address::find($id)->load($relations);
    }
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
        $address = $this->find($id);
        return $address->update($data);
    }
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
        $address = $this->find($id);
        return $address->delete();
    }
}
