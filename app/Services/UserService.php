<?php

namespace App\Services;

use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\People\PeopleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $userRepository;
    protected $peopleRepository;
    protected $employeeRepository;
    public function __construct(UserRepository $userRepository, PeopleRepository $peopleRepository, EmployeeRepository $employeeRepository)
    {
        $this->userRepository = $userRepository;
        $this->peopleRepository = $peopleRepository;
        $this->employeeRepository = $employeeRepository;
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
            $data= array_merge($data, ['people_id' => $people->id]);
            $this->employeeRepository->create($data);
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
