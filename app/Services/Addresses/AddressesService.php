<?php

namespace App\Services\Addresses;

use App\Repositories\Addresses\AddressesRepository;

class AddressesService
{
    protected $addressesRepository;

    public function __construct()
    {
        $this->addressesRepository = new AddressesRepository();
    }
    public function createAddress(array $data)
    {
        return $this->addressesRepository->create($data);
    }
    public function getAllAddress(array $filters, int $perPage = 10)
    {
        return $this->addressesRepository->filter($filters, $perPage);
    }

    public function findAddress(int $id)
    {
        return $this->addressesRepository->find($id);
    }
    public function updateAddress(int $id, array $data)
    {
        return $this->addressesRepository->update($id, $data);
    }
    public function deleteAddress(int $id)
    {
        return $this->addressesRepository->delete($id);
    }
}
