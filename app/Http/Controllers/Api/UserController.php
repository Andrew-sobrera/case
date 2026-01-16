<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return response()->json([
            'users' => $users
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $user = $this->userService->getUserById((int) $id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'user' => $user
        ]);
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $user = $this->userService->getUserById((int) $id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user = $this->userService->updateUser($user, $request->validated());

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $user = $this->userService->getUserById((int) $id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $this->userService->deleteUser($user);

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
