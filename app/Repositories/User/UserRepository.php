<?php

namespace App\Repositories\User;

use App\Interfaces\User\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    public function create(array $data)
    {
        // TODO: Implement create() method.
        return User::create($data);
    }
    public function all()
    {
        // TODO: Implement all() method.
        return User::all();
    }
    public function find(int $id)
    {
        // TODO: Implement find() method.
        return User::find($id);
    }
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
        $user = $this->find($id);
        return $user->update($data);
    }
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
        $user = User::findOrFail($id);
        return $user->delete();
    }
    public function filter(array $filters, $perPage = 10)
    {
        $query = User::query();
        return $query->paginate($perPage);
    }
}
