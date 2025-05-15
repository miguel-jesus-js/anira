<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Repositories\Contracts\BranchRepositoryInterface;
use App\Repositories\Contracts\PeopleRepositoryInterface;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseStatusCode;

class AddressController extends Controller
{
    use ApiResponse;
    protected AddressRepositoryInterface $addressRepository;
    protected PeopleRepositoryInterface $peopleRepository;
    protected BranchRepositoryInterface $branchRepository;

    private const MODEL_PEOPLE = 0;
    private const MODEL_BRANCH = 1;

    public function __construct(AddressRepositoryInterface $addressRepository, PeopleRepositoryInterface $peopleRepository, BranchRepositoryInterface $branchRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->peopleRepository = $peopleRepository;
        $this->branchRepository = $branchRepository;
    }


    /**
     * @param int $model
     * @param int $modelId
     * @param AddressRequest $request
     * @return JsonResponse
     */
    public function store(int $model, int $modelId, AddressRequest $request): JsonResponse
    {
        try {
            $addressInfo = $request->all();
            $entity = match ($model) {
                self::MODEL_PEOPLE => $this->peopleRepository->find($modelId),
                self::MODEL_BRANCH => $this->branchRepository->find($modelId),
            };
            $this->addressRepository->attachAddressToEntity($entity, $addressInfo);
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
     * @param int $peopleId
     * @param int $addressId
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
