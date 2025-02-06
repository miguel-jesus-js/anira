<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Repositories\Addresses\AddressesRepository;
use App\Repositories\People\PeopleRepository;

class AddressController extends Controller
{
    protected $addressRepository;
    protected $peopleRepository;

    public function __construct(AddressesRepository $addressRepository, PeopleRepository $peopleRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->peopleRepository = $peopleRepository;
    }
    public function store(int $peopleId, AddressRequest $request)
    {
        $address = $this->addressRepository->create($request->all());
        $people = $this->peopleRepository->find($peopleId);
        $this->peopleRepository->attach($people, $address);
        return response()->json(['type' => 'success', 'title' => 'Éxito', 'message' => 'Dirrección registrada', 'data' => []], 201);
    }
    public function update(int $addressId, AddressRequest $request)
    {
        $address = $this->addressRepository->update($addressId, $request->all());
        return response()->json(['type' => 'success', 'title' => 'Éxito', 'message' => 'Dirrección actualizada', 'data' => []], 201);
    }
    public function validate(AddressRequest $request)
    {
        return response()->json(['type' => 'success', 'title' => 'Éxito', 'message' => 'Dirrección valida', 'data' => []], 201);
    }

    public function delete(int $id)
    {
        $employee = $this->addressRepository->delete($id);
        return response()->json(['type' => 'success', 'message' => 'Registro eliminado', 'data' => []], 201);
    }
}
