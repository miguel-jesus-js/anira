<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\People\PeopleRepository;
use App\Repositories\User\UserRepository;
use App\Services\Export\ExportService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    use ApiResponse;
    protected EmployeeRepository $employeeRepository;
    protected PeopleRepository $peopleRepository;
    protected UserRepository $userRepository;
    public function __construct(EmployeeRepository $employeeRepository, PeopleRepository $peopleRepository, UserRepository $userRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->peopleRepository = $peopleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try{
            $filters = $request->query('filters', []);
            $relations = ['typeEmployee', 'people', 'people.user'];
            $paginate = $request->query('paginate', false);
            $perPage = $request->query('perPage', 10);
            $employees = $this->employeeRepository->all($filters, $relations, $paginate, $perPage);
            $columnsExport = Employee::columnsExport;
            $filters = Employee::filters;
            $data = [
                'employees' => $employees,
                'columnsExport' => $columnsExport,
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
        try{
            $employee = $this->employeeRepository->find($id, ['typeEmployee', 'people', 'people.user', 'people.addresses']);
            return $this->successResponse(self::MESSAGE_FETCHED, [$employee]);
        } catch (Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $this->employeeRepository->update($id, $data);
            $this->peopleRepository->update($data['people_id'], $data['people']);
            $this->userRepository->update($data['people']['user_id'], $data['people']['user']);
            DB::commit();
            return $this->successResponse(self::MESSAGE_UPDATED);
        } catch (Exception $e) {
            DB::rollBack();
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
            $this->employeeRepository->delete($id);
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
        $columns = array_intersect_key(Employee::columnsExport, array_flip($columnsSelected));
        try {
            $export = new ExportService();
            $archive = $export->exportBase64('employees', $format, $filters, $columns);

            return $this->successResponse(self::MESSAGE_EXPORT, $archive);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
