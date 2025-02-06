<?php

namespace App\Http\Controllers;

use App\Models\TypeCustomer;
use App\Repositories\TypeCustomer\TypeCustomerRepository;
use Illuminate\Http\Request;

class TypeCustomerController extends Controller
{
    protected $typeCustomerRepository;

    public function __construct(TypeCustomerRepository $typeCustomerRepository)
    {
        $this->typeCustomerRepository = $typeCustomerRepository;
    }
    public function index(Request $request)
    {
        $filters = [];
        $perPage = $request->query('perPage', 10);
        $typeCustomers = $this->typeCustomerRepository->all((array)$filters, [], false, $perPage);
        return response()->json($typeCustomers);
    }
}
