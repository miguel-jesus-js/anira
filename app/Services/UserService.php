<?php

namespace App\Services;

use App\Repositories\User\UserRepository;

class UserService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function createUser(array $data)
    {
        return $this->userRepository->create($data);
    }
    public function getAllUsers()
    {
        return $this->userRepository->all();
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
