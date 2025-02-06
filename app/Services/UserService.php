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
    protected $userRepository;
    protected $peopleRepository;
    protected $employeeRepository;
    protected $customerRepository;
    protected $addressRepository;
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
            $this->addressRepository->create($data['addresses'][0]);
            $addresses = Address::whereIn('latitude', array_column($data['addresses'], 'latitude'))
                ->whereIn('longitude', array_column($data['addresses'], 'longitude'))->get()->pluck('id');
            $this->peopleRepository->attach($people, $addresses);
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
    public function getAllUsers(array $filters, int $perPage = 10)
    {
        return $this->userRepository->filter($filters, $perPage);
    }

    public function findUserById(int $id)
    {
        return $this->userRepository->find($id);
    }
    public function updateUser(int $id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }
    public function deleteUser(int $id)
    {
        return $this->userRepository->delete($id);
    }
}
