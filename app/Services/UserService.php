<?php

namespace App\Services;

use App\Models\Address;
use App\Repositories\Addresses\AddressesRepository;
use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\People\PeopleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected UserRepository $userRepository;
    protected PeopleRepository $peopleRepository;
    protected EmployeeRepository $employeeRepository;
    protected CustomerRepository $customerRepository;
    protected AddressesRepository $addressRepository;
    public function __construct(
        UserRepository $userRepository,
        PeopleRepository $peopleRepository,
        EmployeeRepository $employeeRepository,
        CustomerRepository $customerRepository,
        AddressesRepository $addressRepository
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
    public function createUser(array $data)
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
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
