<?php

namespace App\Http\Controllers;

use App\Enums\StatusBase;
use App\Http\Requests\TypeEmployeesRequest;
use App\Models\TypeEmployee;
use App\Repositories\TypeEmployee\TypeEmployeeRepository;
use App\Services\Export\ExportService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;

class TypeEmployeeController extends Controller
{
    use ApiResponse;
    protected $typeEmployeeRepository;
    public function __construct(TypeEmployeeRepository $typeEmployeeRepository)
    {
        $this->typeEmployeeRepository = $typeEmployeeRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try{
            $filters = $request->query('filters');
            $paginate = $request->query('paginate', true);
            $perPage = $request->query('perPage', 10);
            $typeEmployees = $this->typeEmployeeRepository->all($filters, [], $paginate, $perPage);
            $columnsExport = TypeEmployee::columnsExport;
            $filters = TypeEmployee::filters;
            $status = StatusBase::cases();
            $data = [
                'type_employees' => $typeEmployees,
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
        $user = $this->typeEmployeeRepository->find($id);
        return response()->json($user);
    }

    /**
     * @param TypeEmployeesRequest $request
     * @return JsonResponse
     */
    public function store(TypeEmployeesRequest $request): JsonResponse
    {
        try {
            $this->typeEmployeeRepository->create($request->all());
            return $this->successResponse(self::MESSAGE_CREATED);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param TypeEmployeesRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TypeEmployeesRequest $request, int $id): JsonResponse
    {
        try {
            $this->typeEmployeeRepository->update($id, $request->all());
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
            $this->typeEmployeeRepository->delete($id);
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
        $columns = array_intersect_key(TypeEmployee::columnsExport, array_flip($columnsSelected));

        try {
            $export = new ExportService();
            $archive = $export->exportBase64('type_employees', $format, $filters, $columns);

            return $this->successResponse(self::MESSAGE_CREATED, $archive);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
