<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\PeopleRequest;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        $filters = [];
        $perPage = $request->query('perPage', 10);
        $users = $this->userService->getAllUsers((array)$filters, $perPage);
        return response()->json($users);
    }
    public function store(UserRequest $request)
    {
        try {
            $this->userService->createUser($request->all());
            return response()->json(['type' => 'success', 'title' => 'Éxito', 'message' => 'Empleado creado', 'data' => []], 201);
        } catch (\Exception $e) {
            return response()->json(['type' => 'error', 'title' => 'Éxito', 'message' => 'Ocurrió un error al crear el empleado', 'data' => [$e->getMessage()]], 500);
        }
    }
    public function update(Request $request, int $id)
    {
        $users = $this->userService->updateUser($id, $request->all());
        return response()->json($users);
    }
    public function destroy(int $id)
    {
        $users = $this->userService->deleteUser($id);
        return response()->json($users);
    }
    public function show(int $id)
    {
        $user = $this->userService->findUserById($id);
        return response()->json($user);
    }
}
