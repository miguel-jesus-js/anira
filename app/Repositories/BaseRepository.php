<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseRepository implements BaseRepositoryInterface
{
    use ApiResponse;
    protected Model $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @throws Exception
     */
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

    /**
     * @throws Exception
     */
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

    public function attach(int $modelId, Model $model)
    {

    }

    public function detach(int $modelId, Model $model)
    {

    }

    protected function applyFilters($query, array $filters){

    }
}
