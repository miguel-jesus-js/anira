<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Models\Table;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Services\Export\ExportService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;
class TablesController extends Controller
{
    use ApiResponse;
    protected TableRepositoryInterface $tableRepository;

    public function __construct(TableRepositoryInterface $tableRepository)
    {
        $this->tableRepository = $tableRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try{
            $filters = $request->query('filters', []);
            $paginate = $request->query('paginate', false);
            $perPage = $request->query('perPage', 10);
            $typeCustomers = $this->tableRepository->all($filters, ['typeTable'], $paginate, $perPage);
            $columnsExport = Table::columnsExport;
            $data = [
                'tables' => $typeCustomers,
                'columns_export' => $columnsExport,
                'filters' => $filters,
            ];
            return $this->successResponse(self::MESSAGE_FETCHED, $data);
        } catch (Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(int $id): JsonResponse
    {
        try {
            $typeEmployee = $this->tableRepository->find($id);
            return $this->successResponse(self::MESSAGE_CREATED, [$typeEmployee]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param TableRequest $request
     * @return JsonResponse
     */
    public function store(TableRequest $request): JsonResponse
    {
        try {
            $this->tableRepository->create($request->all());
            return $this->successResponse(self::MESSAGE_CREATED);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param TableRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TableRequest $request, int $id): JsonResponse
    {
        try {
            $this->tableRepository->update($id, $request->all());
            return $this->successResponse(self::MESSAGE_UPDATED);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            $this->tableRepository->delete($id);
            return $this->successResponse(self::MESSAGE_DELETED);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function export(Request $request): JsonResponse
    {
        $format = $request->query('format');
        $filters = $request->query('filters', []);
        $columnsSelected = $request->query('columns_selected', []);
        $columns = array_intersect_key(Table::columnsExport, array_flip($columnsSelected));

        try {
            $export = new ExportService();
            $archive = $export->exportBase64('tables', $format, $filters, $columns);

            return $this->successResponse(self::MESSAGE_CREATED, $archive);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
