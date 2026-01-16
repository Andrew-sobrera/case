<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AssignPermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Services\PermissionService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class PermissionController
{
    protected PermissionService $permissionService;
    protected UserService $userService;

    public function __construct(PermissionService $permissionService, UserService $userService)
    {
        $this->permissionService = $permissionService;
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $permissions = $this->permissionService->getAllPermissions();
        
        return response()->json([
            'status' => 'success',
            'data' => $permissions
        ], 200);
    }
    
    public function store(StorePermissionRequest $request): JsonResponse
    {
        $permission = $this->permissionService->createPermission($request->validated());
        
        return response()->json([
            'status' => 'success',
            'message' => 'Permission created successfully',
            'data' => $permission
        ], 201);
    }
    
    public function show(int $id): JsonResponse
    {
        $permission = $this->permissionService->getPermissionById($id);
        
        if (!$permission) {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission not found'
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $permission
        ], 200);
    }
    
    public function update(UpdatePermissionRequest $request, int $id): JsonResponse
    {
        $permission = $this->permissionService->getPermissionById($id);
        
        if (!$permission) {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission not found'
            ], 404);
        }
        
        $updatedPermission = $this->permissionService->updatePermission($permission, $request->validated());
        
        return response()->json([
            'status' => 'success',
            'message' => 'Permission updated successfully',
            'data' => $updatedPermission
        ], 200);
    }
    
    public function destroy(int $id): JsonResponse
    {
        $permission = $this->permissionService->getPermissionById($id);
        
        if (!$permission) {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission not found'
            ], 404);
        }
        
        $this->permissionService->deletePermission($permission);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Permission deleted successfully'
        ], 200);
    }

    public function userPermissions(int $userId): JsonResponse
    {
        $user = $this->userService->getUserById($userId);
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
        
        $permissions = $this->permissionService->getUserPermissions($user);
        
        return response()->json([
            'status' => 'success',
            'data' => $permissions
        ], 200);
    }

    public function assign(AssignPermissionRequest $request, int $userId): JsonResponse
    {
        $user = $this->userService->getUserById($userId);
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
        
        $permission = $this->permissionService->getPermissionById($request->validated()['permission_id']);
        
        if (!$permission) {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission not found'
            ], 404);
        }
        
        $this->permissionService->assignPermissionToUser($user, $permission);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Permission assigned successfully'
        ], 200);
    }

    public function revoke(int $userId, int $permissionId): JsonResponse
    {
        $user = $this->userService->getUserById($userId);
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
        
        $permission = $this->permissionService->getPermissionById($permissionId);
        
        if (!$permission) {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission not found'
            ], 404);
        }
        
        $this->permissionService->revokePermissionFromUser($user, $permission);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Permission revoked successfully'
        ], 200);
    }
}
