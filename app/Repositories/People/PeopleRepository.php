<?php

namespace App\Repositories\People;

use App\Interfaces\AttachableInterface;
use App\Models\People;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;

class PeopleRepository extends BaseRepository implements AttachableInterface
{
    public function __construct(People $people)
    {
        parent::__construct($people);
    }

    /**
     * @throws Exception
     */
    public function attach(int $id, Model $idRelation): void
    {
        $address = $this->find($id);
        $address->addresses()->attach($idRelation);
    }
}
