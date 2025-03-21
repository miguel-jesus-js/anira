<?php

namespace App\Services;

use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Repositories\Contracts\PeopleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Exception;

class UserService
{
    use ApiResponse;
    protected UserRepositoryInterface $userRepository;
    protected PeopleRepositoryInterface $peopleRepository;
    protected EmployeeRepositoryInterface $employeeRepository;
    protected CustomerRepositoryInterface $customerRepository;
    protected AddressRepositoryInterface $addressRepository;
    public function __construct(
        UserRepositoryInterface     $userRepository,
        PeopleRepositoryInterface   $peopleRepository,
        EmployeeRepositoryInterface $employeeRepository,
        CustomerRepositoryInterface $customerRepository,
        AddressRepositoryInterface  $addressRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->peopleRepository = $peopleRepository;
        $this->employeeRepository = $employeeRepository;
        $this->customerRepository = $customerRepository;
        $this->addressRepository = $addressRepository;
    }

    /**
     * @throws \Exception
     */
    public function createUser(array $data): true
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->create($data['user']);
            $data['people'] = array_merge($data['people'], ['user_id' => $user->id]);
            $people = $this->peopleRepository->create($data['people']);
            if(sizeof($data['addresses']) > 0)
            {
                foreach ($data['addresses'] as $address)
                {
                    $existingAddress = $this->addressRepository->existAddressWithLocation($address['latitude'], $address['longitude']);
                    if(is_null($existingAddress))
                    {
                        $newAddress = $this->addressRepository->create($data['addresses'][0]);
                        $this->peopleRepository->attach($people->id, $newAddress);
                    }else{
                        $this->peopleRepository->attach($people->id, $existingAddress);
                    }
                }
            }
            $data= array_merge($data, ['people_id' => $people->id]);
            if($data['type_entity'] == 'employee')
            {
                $this->employeeRepository->create($data);
            }else{
                $this->customerRepository->create($data);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(self::ERROR_CREATED);
        }
    }
}
