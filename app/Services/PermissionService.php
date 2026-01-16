<?php

namespace App\Services;

use App\Contracts\PermissionRepositoryInterface;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PermissionService
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepository
    ) {}

    public function getAllPermissions(): Collection
    {
        return $this->permissionRepository->getAll();
    }

    public function getPermissionById(int $id): ?Permission
    {
        return $this->permissionRepository->findById($id);
    }
    
    public function createPermission(array $data): Permission
    {
        return $this->permissionRepository->create($data);
    }
    
    public function updatePermission(Permission $permission, array $data): Permission
    {
        return $this->permissionRepository->update($permission, $data);
    }
    
    public function deletePermission(Permission $permission): bool
    {
        return $this->permissionRepository->delete($permission);
    }

    public function getUserPermissions(User $user): Collection
    {
        return $this->permissionRepository->getUserPermissions($user);
    }

    public function assignPermissionToUser(User $user, Permission $permission): void
    {
        $this->permissionRepository->assignToUser($user, $permission);
    }

    public function revokePermissionFromUser(User $user, Permission $permission): void
    {
        $this->permissionRepository->revokeFromUser($user, $permission);
    }

    public function userHasPermission(User $user, string $permissionName): bool
    {
        return $this->permissionRepository->userHasPermission($user, $permissionName);
    }
}
