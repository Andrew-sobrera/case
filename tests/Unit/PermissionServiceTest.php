<?php

namespace Tests\Unit;

use App\Models\Permission;
use App\Models\User;
use App\Repositories\PermissionRepository;
use App\Services\PermissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PermissionService $permissionService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->permissionService = new PermissionService(new PermissionRepository());
    }

    public function test_can_get_all_permissions(): void
    {
        Permission::factory()->count(3)->create();

        $permissions = $this->permissionService->getAllPermissions();

        $this->assertCount(3, $permissions);
    }

    public function test_can_get_permission_by_id(): void
    {
        $permission = Permission::factory()->create();

        $foundPermission = $this->permissionService->getPermissionById($permission->id);

        $this->assertNotNull($foundPermission);
        $this->assertEquals($permission->id, $foundPermission->id);
    }

    public function test_can_create_permission(): void
    {
        $data = [
            'name' => 'test-permission',
            'description' => 'Test Permission',
        ];

        $permission = $this->permissionService->createPermission($data);

        $this->assertEquals('test-permission', $permission->name);
        $this->assertDatabaseHas('permissions', ['name' => 'test-permission']);
    }

    public function test_can_update_permission(): void
    {
        $permission = Permission::factory()->create(['name' => 'original-name']);

        $updatedPermission = $this->permissionService->updatePermission($permission, ['name' => 'updated-name']);

        $this->assertEquals('updated-name', $updatedPermission->name);
    }

    public function test_can_delete_permission(): void
    {
        $permission = Permission::factory()->create();

        $result = $this->permissionService->deletePermission($permission);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
    }

    public function test_can_get_user_permissions(): void
    {
        $user = User::factory()->create();
        $permissions = Permission::factory()->count(2)->create();
        $user->permissions()->attach($permissions->pluck('id'));

        $userPermissions = $this->permissionService->getUserPermissions($user);

        $this->assertCount(2, $userPermissions);
    }

    public function test_can_assign_permission_to_user(): void
    {
        $user = User::factory()->create();
        $permission = Permission::factory()->create();

        $this->permissionService->assignPermissionToUser($user, $permission);

        $this->assertDatabaseHas('permission_user', [
            'user_id' => $user->id,
            'permission_id' => $permission->id,
        ]);
    }

    public function test_can_revoke_permission_from_user(): void
    {
        $user = User::factory()->create();
        $permission = Permission::factory()->create();
        $user->permissions()->attach($permission->id);

        $this->permissionService->revokePermissionFromUser($user, $permission);

        $this->assertDatabaseMissing('permission_user', [
            'user_id' => $user->id,
            'permission_id' => $permission->id,
        ]);
    }

    public function test_user_has_permission_returns_true_when_assigned(): void
    {
        $user = User::factory()->create();
        $permission = Permission::factory()->create(['name' => 'test-permission']);
        $user->permissions()->attach($permission->id);

        $hasPermission = $this->permissionService->userHasPermission($user, 'test-permission');

        $this->assertTrue($hasPermission);
    }

    public function test_user_has_permission_returns_false_when_not_assigned(): void
    {
        $user = User::factory()->create();
        Permission::factory()->create(['name' => 'test-permission']);

        $hasPermission = $this->permissionService->userHasPermission($user, 'test-permission');

        $this->assertFalse($hasPermission);
    }
}
