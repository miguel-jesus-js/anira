<?php

namespace App\Repositories\People;

use App\Models\Address;
use App\Models\People;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\PeopleRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class PeopleRepository extends BaseRepository implements PeopleRepositoryInterface
{
    public function __construct(People $people)
    {
        parent::__construct($people);
    }
}
