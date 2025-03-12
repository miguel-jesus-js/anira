<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponse;
use Exception;

abstract class BaseRepository implements BaseRepositoryInterface
{
    use ApiResponse;
    protected Model $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        try {
            return $this->model::create($data);
        } catch (Exception $e) {
            throw new Exception(self::ERROR_CREATED, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function all(array $filters = [], array $relations = [], bool $paginate = false, int $perPage = 10): \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        try {
            $query = $this->model->with($relations);
            $this->applyFilters($query, $filters);
            return $paginate ? $query->paginate($perPage) : $query->get();
        } catch (Exception $e) {
            throw new Exception(self::ERROR_FETCHED, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    public function find(int $id, array $relations = [])
    {
        try {
            return $this->model::findOrFail($id)->load($relations);
        } catch (Exception $e) {
            throw new Exception(self::ERROR_FETCHED, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
        $record = $this->find($id);
        return $record->update($data);
    }

    /**
     * @throws Exception
     */
    public function delete(int $id)
    {
        try {
            $record = $this->find($id);
            return $record->delete();
        } catch (Exception $e) {
            throw new Exception(self::ERROR_DELETED, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function applyFilters($query, array $filters){

    }
}
