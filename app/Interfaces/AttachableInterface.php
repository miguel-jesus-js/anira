<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface AttachableInterface
{
    public function attach(int $id, Model $idRelation);
}
