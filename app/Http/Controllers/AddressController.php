<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Repositories\Contracts\AddressesRepositoryInterface;
use App\Repositories\Contracts\PeopleRepositoryInterface;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseStatusCode;

class AddressController extends Controller
{
    use ApiResponse;
    protected AddressesRepositoryInterface $addressesRepository;
    protected PeopleRepositoryInterface $peopleRepository;

    public function __construct(AddressesRepositoryInterface $addressesRepository, PeopleRepositoryInterface $peopleRepository)
    {
        $this->addressesRepository = $addressesRepository;
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
            $existingAddress = $this->addressesRepository->existAddressWithLocation($addressInfo['latitude'], $addressInfo['longitude']);
            $people = $this->peopleRepository->find($peopleId);
            if(is_null($existingAddress))
            {
                $newAddress = $this->addressesRepository->create($addressInfo);
                $this->attachAddressToPerson($people->id, $newAddress);
            }else{
                if(!$existingAddress->people()->exists())
                {
                    $this->attachAddressToPerson($people->id, $existingAddress);
                }else{
                    return $this->errorResponse('La dirección ya existe', ResponseStatusCode::HTTP_CONFLICT);
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
            $this->addressesRepository->update($id, $request->all());
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
    public function delete(int $peopleId, int $addressId): JsonResponse
    {
        try {
            $people = $this->peopleRepository->find($peopleId);
            $address = $this->addressesRepository->find($addressId);
            $this->peopleRepository->detach($people->id, $address);
            return $this->successResponse(self::MESSAGE_DELETED);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    private function attachAddressToPerson(int $personId, Model $address): void
    {
        $this->peopleRepository->attach($personId, $address);
    }
}
