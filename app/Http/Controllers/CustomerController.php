<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Contracts\PeopleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Export\ExportService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    use ApiResponse;
    protected CustomerRepositoryInterface $customerRepository;
    protected PeopleRepositoryInterface $peopleRepository;
    protected UserRepositoryInterface $userRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository, PeopleRepositoryInterface $peopleRepository, UserRepositoryInterface $userRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->peopleRepository = $peopleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->query('filters', []);
            $relations = ['typeCustomer', 'people', 'people.user'];
            $paginate = $request->query('paginate', false);
            $perPage = $request->query('perPage', 10);
            $customers = $this->customerRepository->all($filters, $relations, $paginate, $perPage);
            $columnsExport = Customer::columnsExport;
            $filters = Customer::filters;
            $data = [
                'customers' => $customers,
                'columnsExport' => $columnsExport,
                'filters' => $filters,
            ];
            return $this->successResponse(self::MESSAGE_FETCHED, $data);
        } catch (Exception $e) {
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
            $customer = $this->customerRepository->find($id, ['typeCustomer', 'people', 'people.user', 'people.addresses']);
            return $this->successResponse(self::MESSAGE_FETCHED, [$customer]);
        } catch (Exception $e) {
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
            $this->customerRepository->update($id, $data);
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
            $this->customerRepository->delete($id);
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
        $columns = array_intersect_key(Customer::columnsExport, array_flip($columnsSelected));
        try {
            $export = new ExportService();
            $archive = $export->exportBase64('customers', $format, $filters, $columns);
            return $this->successResponse(self::MESSAGE_CREATED, $archive);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
