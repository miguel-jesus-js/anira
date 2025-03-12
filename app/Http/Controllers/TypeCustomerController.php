<?php

namespace App\Http\Controllers;

use App\Enums\StatusBase;
use App\Http\Requests\TypeCustomersRequest;
use App\Models\TypeCustomer;
use App\Repositories\TypeCustomer\TypeCustomerRepository;
use App\Services\Export\ExportService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class TypeCustomerController extends Controller
{
    use ApiResponse;
    protected TypeCustomerRepository $typeCustomerRepository;

    public function __construct(TypeCustomerRepository $typeCustomerRepository)
    {
        $this->typeCustomerRepository = $typeCustomerRepository;
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
            $typeCustomers = $this->typeCustomerRepository->all($filters, [], $paginate, $perPage);
            $columnsExport = TypeCustomer::columnsExport;
            $filters = TypeCustomer::filters;
            $status = StatusBase::cases();
            $data = [
                'type_customers' => $typeCustomers,
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
            $typeEmployee = $this->typeCustomerRepository->find($id);
            return $this->successResponse(self::MESSAGE_CREATED, [$typeEmployee]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param TypeCustomersRequest $request
     * @return JsonResponse
     */
    public function store(TypeCustomersRequest $request): JsonResponse
    {
        try {
            $this->typeCustomerRepository->create($request->all());
            return $this->successResponse(self::MESSAGE_CREATED);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param TypeCustomersRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TypeCustomersRequest $request, int $id): JsonResponse
    {
        try {
            $this->typeCustomerRepository->update($id, $request->all());
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
            $this->typeCustomerRepository->delete($id);
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
        $columns = array_intersect_key(TypeCustomer::columnsExport, array_flip($columnsSelected));

        try {
            $export = new ExportService();
            $archive = $export->exportBase64('type_customers', $format, $filters, $columns);

            return $this->successResponse(self::MESSAGE_CREATED, $archive);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
