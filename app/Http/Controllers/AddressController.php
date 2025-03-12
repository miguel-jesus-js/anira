<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Repositories\Addresses\AddressesRepository;
use App\Repositories\People\PeopleRepository;
use Exception;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    use ApiResponse;
    protected AddressesRepository $addressRepository;
    protected PeopleRepository $peopleRepository;
    public function __construct(AddressesRepository $addressRepository, PeopleRepository $peopleRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->peopleRepository = $peopleRepository;
    }


    /**
     * @param int $peopleId
     * @param AddressRequest $request
     * @return JsonResponse
     */
    public function store(int $peopleId, AddressRequest $request): JsonResponse
    {
        try {
            $addressInfo = $request->all();
            $existingAddress = $this->addressRepository->existAddressWithLocation($addressInfo['latitude'], $addressInfo['longitude']);
            $people = $this->peopleRepository->find($peopleId);
            if(is_null($existingAddress))
            {
                $newAddress = $this->addressRepository->create($addressInfo);
                $this->peopleRepository->attach($people->id, $newAddress);
            }else{
                if(!$existingAddress->people()->exists())
                {
                    $this->peopleRepository->attach($people->id, $existingAddress);
                }
            }
            return $this->successResponse(self::MESSAGE_CREATED);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param int $id
     * @param AddressRequest $request
     * @return JsonResponse
     */
    public function update(int $id, AddressRequest $request): JsonResponse
    {
        try {
            $this->addressRepository->update($id, $request->all());
            return $this->successResponse(self::MESSAGE_UPDATED);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param AddressRequest $request
     * @return JsonResponse
     */
    public function validate(AddressRequest $request): JsonResponse
    {
        return $this->successResponse('Dirección validada');
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(int $id): JsonResponse
    {
        try {
            $this->addressRepository->delete($id);
            return $this->successResponse(self::MESSAGE_DELETED);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
