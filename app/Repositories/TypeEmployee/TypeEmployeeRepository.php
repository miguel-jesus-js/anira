<?php

namespace App\Repositories\TypeEmployee;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\TypeEmployee;
use App\Traits\ApiResponse;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class TypeEmployeeRepository implements BaseRepositoryInterface
{
    use ApiResponse;
    protected $typeEmployee;
    public function __construct(TypeEmployee $typeEmployee)
    {
        $this->typeEmployee = $typeEmployee;
    }

    /**
     * @throws Exception
     */
    public function create(array $data)
    {
        try {
            return TypeEmployee::create($data);
        } catch (Exception $e) {
            throw new Exception(self::ERROR_CREATED, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function all(array $filters = [], array $relations = [], bool $paginate = false, int $perPage = 10)
    {
        try {
            $query = $this->typeEmployee->newQuery();
            if(!empty($filters['type_employee']))
            {
                $query->typeEmployee($filters['type_employee']);
            }
            $query->with($relations);
            if($paginate)
            {
                return $query->paginate($perPage);
            }
            return $query->get();
        } catch (Exception $e) {
            throw new Exception(self::ERROR_FETCHED, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    public function find(int $id)
    {
        try {
            return TypeEmployee::findOrFail($id);
        } catch (Exception $e) {
            throw new Exception(self::ERROR_FETCHED, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
        $typeEmployee = $this->find($id);
        return $typeEmployee->update($data);
    }

    /**
     * @throws Exception
     */
    public function delete(int $id)
    {
        try {
            $typeEmployee = $this->find($id);
            return $typeEmployee->delete();
        } catch (Exception $e) {
            throw new Exception(self::ERROR_DELETED, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
