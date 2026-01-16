<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getAll(bool $withTrashed = false): Collection;

    public function findById(int $id, bool $withTrashed = false): ?User;

    public function findByEmail(string $email): ?User;

    public function findByCpf(string $cpf): ?User;

    public function create(array $data): User;

    public function update(User $user, array $data): User;

    public function delete(User $user): bool;

    public function restore(User $user): bool;

    public function forceDelete(User $user): bool;
}
