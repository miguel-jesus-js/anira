<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Repositories\Contracts\BranchRepositoryInterface;
use App\Services\Export\ExportService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    use ApiResponse;
    protected BranchRepositoryInterface $branchRepository;
    protected AddressRepositoryInterface $addressRepository;
    public function __construct(BranchRepositoryInterface $branchRepository, AddressRepositoryInterface $addressRepository)
    {
        $this->branchRepository = $branchRepository;
        $this->addressRepository = $addressRepository;
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
            $branches = $this->branchRepository->all($filters, ['address'], $paginate, $perPage);
            $columnsExport = Branch::columnsExport;
            $data = [
                'branches' => $branches,
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
            $branch = $this->branchRepository->find($id, ['address', 'employee.people']);
            return $this->successResponse(self::MESSAGE_CREATED, [$branch]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
    /**
     * @param BranchRequest $request
     * @return JsonResponse
     */
    public function store(BranchRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $branchInfo = $request->all();
            $branch = $this->branchRepository->create($branchInfo);
            if($branchInfo['address'])
            {
                $this->addressRepository->attachAddressToEntity($branch, $branchInfo['address'][0]);
            }
            DB::commit();
            return $this->successResponse(self::MESSAGE_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param int $id
     * @param BranchRequest $request
     * @return JsonResponse
     */
    public function update(int $id, BranchRequest $request): JsonResponse
    {
        try {
            $this->branchRepository->update($id, $request->all());
            return $this->successResponse(self::MESSAGE_UPDATED);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param int $branchId
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(int $branchId): JsonResponse
    {
        try {
            $this->branchRepository->delete($branchId);
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
        $columnsSelected = $request->query('columns_selected');
        $columns = array_intersect_key(Branch::columnsExport, array_flip($columnsSelected));
        try {
            $export = new ExportService();
            $archive = $export->exportBase64('branch', $format, $filters, $columns);
            return $this->successResponse(self::MESSAGE_CREATED, $archive);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}

