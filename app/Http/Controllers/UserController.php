<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use ApiResponse;
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        try {
            $this->userService->createUser($request->all());
            return $this->successResponse(self::MESSAGE_CREATED);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
