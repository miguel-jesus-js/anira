<?php

namespace App\Interfaces\TypeEmployee;

interface TypeEmployeeInterface
{
    public function create(array $data);
    public function all();
    public function find(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
}
