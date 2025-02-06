<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Repositories\Customers\CustomerRepository;
use App\Repositories\People\PeopleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerRepository;
    protected $peopleRepository;
    protected $userRepository;

    public function __construct(CustomerRepository $customerRepository, PeopleRepository $peopleRepository, UserRepository $userRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->peopleRepository = $peopleRepository;
        $this->userRepository = $userRepository;
    }
    public function index(Request $request)
    {
        $filters = $request->query('filters');
        $relations = ['typeCustomer', 'people', 'people.user'];
        $paginate = $request->query('paginate', true);
        $perPage = $request->query('perPage', 10);
        $employees = $this->customerRepository->all($filters, $relations, $paginate, $perPage);
        $columnsExport = Customer::columnsExport;
        $filters = Customer::filters;
        return response()->json([
            'type' => 'success',
            'message' => 'Datos consultados',
            'data' => $employees,
            'columnsExport' => $columnsExport,
            'filters' => $filters,
        ], 201);
    }

    public function show(int $id)
    {
        $customer = $this->customerRepository->find($id, ['typeCustomer', 'people', 'people.user', 'people.addresses']);
        return response()->json(['type' => 'success', 'message' => 'Datos obtenidos', 'data' => $customer], 201);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->all();
        $customer = $this->customerRepository->update($id, $data);
        $people = $this->peopleRepository->update($data['people_id'], $data['people']);
        $jsj = $data['people']['user_id'];
        $user = $this->userRepository->update($data['people']['user_id'], $data['people']['user']);
        return response()->json(['type' => 'success', 'message' => 'Registro actualizado', 'data' => []], 201);
    }
}
