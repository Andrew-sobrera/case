<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getAll(bool $withTrashed = false): Collection
    {
        $query = User::query();

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->get();
    }

    public function findById(int $id, bool $withTrashed = false): ?User
    {
        $query = User::query();

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findByCpf(string $cpf): ?User
    {
        return User::where('cpf', $cpf)->first();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function restore(User $user): bool
    {
        return $user->restore();
    }

    public function forceDelete(User $user): bool
    {
        return $user->forceDelete();
    }
}
