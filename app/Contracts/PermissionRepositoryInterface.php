<?php

namespace App\Contracts;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): ?Permission;

    public function findByName(string $name): ?Permission;

    public function getUserPermissions(User $user): Collection;

    public function assignToUser(User $user, Permission $permission): void;

    public function revokeFromUser(User $user, Permission $permission): void;

    public function userHasPermission(User $user, string $permissionName): bool;
}
