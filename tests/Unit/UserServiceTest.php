<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService(new UserRepository());
    }

    public function test_can_create_user_with_hashed_password(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'cpf' => '12345678901',
            'password' => 'plainpassword',
        ];

        $user = $this->userService->createUser($data);

        $this->assertNotEquals('plainpassword', $user->password);
        $this->assertTrue(password_verify('plainpassword', $user->password));
    }

    public function test_can_get_all_users(): void
    {
        User::factory()->count(3)->create();

        $users = $this->userService->getAllUsers();

        $this->assertCount(3, $users);
    }

    public function test_can_get_user_by_id(): void
    {
        $user = User::factory()->create();

        $foundUser = $this->userService->getUserById($user->id);

        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    public function test_email_exists_returns_true_for_existing_email(): void
    {
        $user = User::factory()->create(['email' => 'existing@example.com']);

        $exists = $this->userService->emailExists('existing@example.com');

        $this->assertTrue($exists);
    }

    public function test_email_exists_returns_false_for_nonexistent_email(): void
    {
        $exists = $this->userService->emailExists('nonexistent@example.com');

        $this->assertFalse($exists);
    }

    public function test_cpf_exists_returns_true_for_existing_cpf(): void
    {
        $user = User::factory()->create(['cpf' => '12345678901']);

        $exists = $this->userService->cpfExists('12345678901');

        $this->assertTrue($exists);
    }

    public function test_cpf_exists_returns_false_for_nonexistent_cpf(): void
    {
        $exists = $this->userService->cpfExists('99999999999');

        $this->assertFalse($exists);
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->create(['name' => 'Original Name']);

        $updatedUser = $this->userService->updateUser($user, ['name' => 'Updated Name']);

        $this->assertEquals('Updated Name', $updatedUser->name);
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->create();

        $result = $this->userService->deleteUser($user);

        $this->assertTrue($result);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_update_password_hashes_new_password(): void
    {
        $user = User::factory()->create();

        $updatedUser = $this->userService->updateUser($user, ['password' => 'newpassword']);

        $this->assertTrue(password_verify('newpassword', $updatedUser->password));
    }
}
