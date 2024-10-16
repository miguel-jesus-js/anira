<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users);
    }
    public function store(Request $request)
    {
        $users = $this->userService->createUser($request->all());
        return response()->json($users);
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
