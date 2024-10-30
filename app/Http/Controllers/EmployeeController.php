<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\Employee\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeService;
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }
    public function index(Request $request)
    {
        $filters = [];
        $perPage = $request->query('perPage', 10);
        $employees = $this->employeeService->getAllEmployees($filters, ['typeEmployee', 'people', 'people.user'], $perPage);
        return response()->json(['type' => 'success', 'message' => 'Datos consultados', 'data' => $employees], 201);
    }
}
