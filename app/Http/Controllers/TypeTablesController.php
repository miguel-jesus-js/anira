<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeTableRequest;
use App\Models\TypeTable;
use App\Repositories\TypeTable\TypeTableRepository;
use App\Services\Export\ExportService;
use App\Traits\ApiResponse;
use App\Enums\StatusBase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeTablesController extends Controller
{
    use ApiResponse;
    protected TypeTableRepository $typeTableRepository;

    public function __construct(TypeTableRepository $typeTableRepository)
    {
        $this->typeTableRepository = $typeTableRepository;
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
            $tableTypes = $this->typeTableRepository->all($filters, [], $paginate, $perPage);
            $columnsExport = TypeTable::columnsExport;
            $filters = TypeTable::filters;
            $status = StatusBase::cases();
            $data = [
                'type_tables' => $tableTypes,
                'status' => $status,
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
            $tableType = $this->typeTableRepository->find($id);
            return $this->successResponse(self::MESSAGE_CREATED, [$tableType]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param TypeTableRequest $request
     * @return JsonResponse
     */
    public function store(TypeTableRequest $request): JsonResponse
    {
        try {
            $this->typeTableRepository->create($request->all());
            return $this->successResponse(self::MESSAGE_CREATED);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param TypeTableRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TypeTableRequest $request, int $id): JsonResponse
    {
        try {
            $this->typeTableRepository->update($id, $request->all());
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
            $this->typeTableRepository->delete($id);
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
        $columns = array_intersect_key(TypeTable::columnsExport, array_flip($columnsSelected));

        try {
            $export = new ExportService();
            $archive = $export->exportBase64('table_types', $format, $filters, $columns);

            return $this->successResponse(self::MESSAGE_CREATED, $archive);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
