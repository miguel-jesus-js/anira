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
        $filters = $request->query('filters');
        $perPage = $request->query('perPage', 10);
        $employees = $this->employeeService->getAllEmployees($filters, ['typeEmployee', 'people', 'people.user'], $perPage);
        return response()->json(['type' => 'success', 'message' => 'Datos consultados', 'data' => $employees], 201);
    }
    public function show(int $id)
    {
        $employee = $this->employeeService->findEmployeeById($id, ['typeEmployee', 'people', 'people.user']);
        return response()->json(['type' => 'success', 'message' => 'Datos obtenidos', 'data' => $employee], 201);
    }
}
