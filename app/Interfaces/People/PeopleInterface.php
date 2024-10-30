<?php

namespace App\Interfaces\People;

interface PeopleInterface
{
    public function create(array $data);
    public function all();
    public function find(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
}
