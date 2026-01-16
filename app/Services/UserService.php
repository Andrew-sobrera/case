<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function getAllUsers(bool $withTrashed = false): Collection
    {
        return $this->userRepository->getAll($withTrashed);
    }

    public function getUserById(int $id, bool $withTrashed = false): ?User
    {
        return $this->userRepository->findById($id, $withTrashed);
    }

    public function createUser(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->create($data);
    }

    public function updateUser(User $user, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($user, $data);
    }

    public function deleteUser(User $user): bool
    {
        return $this->userRepository->delete($user);
    }

    public function restoreUser(User $user): bool
    {
        return $this->userRepository->restore($user);
    }

    public function emailExists(string $email, ?int $exceptUserId = null): bool
    {
        $user = $this->userRepository->findByEmail($email);
        
        if (!$user) {
            return false;
        }

        return $exceptUserId ? $user->id !== $exceptUserId : true;
    }

    public function cpfExists(string $cpf, ?int $exceptUserId = null): bool
    {
        $user = $this->userRepository->findByCpf($cpf);
        
        if (!$user) {
            return false;
        }

        return $exceptUserId ? $user->id !== $exceptUserId : true;
    }
}
