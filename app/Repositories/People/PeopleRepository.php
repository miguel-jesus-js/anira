<?php

namespace App\Repositories\People;

use App\Interfaces\People\PeopleInterface;
use App\Models\People;

class PeopleRepository implements PeopleInterface
{
    protected $people;
    public function __construct(People $people)
    {
        $this->people = $people;
    }
    public function create(array $data)
    {
        // TODO: Implement create() method.
        return People::create($data);
    }
    public function all()
    {
        // TODO: Implement all() method.
        return People::all();
    }
    public function find(int $id)
    {
        // TODO: Implement find() method.
        return People::find($id);
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
        $user = People::findOrFail($id);
        return $user->delete();
    }
    public function filter(array $filters, $perPage = 10)
    {
        $query = People::query();
        return $query->paginate($perPage);
    }

    public function attach(People $people,  $address)
    {
        $people->addresses()->attach($address);
    }
}
