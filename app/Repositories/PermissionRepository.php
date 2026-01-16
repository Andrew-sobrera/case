<?php

namespace App\Repositories;

use App\Contracts\PermissionRepositoryInterface;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function getAll(): Collection
    {
        return Permission::all();
    }

    public function findById(int $id): ?Permission
    {
        return Permission::find($id);
    }

    public function findByName(string $name): ?Permission
    {
        return Permission::where('name', $name)->first();
    }

    public function getUserPermissions(User $user): Collection
    {
        return $user->permissions;
    }

    public function assignToUser(User $user, Permission $permission): void
    {
        if (!$user->permissions->contains($permission->id)) {
            $user->permissions()->attach($permission->id);
        }
    }

    public function revokeFromUser(User $user, Permission $permission): void
    {
        $user->permissions()->detach($permission->id);
    }

    public function userHasPermission(User $user, string $permissionName): bool
    {
        return $user->permissions->contains('name', $permissionName);
    }
}
