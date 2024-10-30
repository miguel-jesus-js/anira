<?php

namespace App\Http\Controllers;

use App\Services\TypeEmployeeService\TypeEmployeeService;
use Illuminate\Http\Request;

class TypeEmployeeController extends Controller
{
    protected $typemEmployeeService;
    public function __construct(TypeEmployeeService $typemEmployeeService)
    {
        $this->typemEmployeeService = $typemEmployeeService;
    }
    public function index(Request $request)
    {
        $filters = [];
        $perPage = $request->query('perPage', 10);
        $users = $this->typemEmployeeService->getAllTypeEmployee((array)$filters, $perPage);
        return response()->json($users);
    }
    public function store(Request $request)
    {
        $users = $this->typemEmployeeService->createTypeEmployee($request->all());
        return response()->json($users);
    }
    public function update(Request $request, int $id)
    {
        $users = $this->typemEmployeeService->updateTypeEmployee($id, $request->all());
        return response()->json($users);
    }
    public function destroy(int $id)
    {
        $users = $this->typemEmployeeService->deleteTypeEmployee($id);
        return response()->json($users);
    }
    public function show(int $id)
    {
        $user = $this->typemEmployeeService->findTypeEmployeeById($id);
        return response()->json($user);
    }
}
