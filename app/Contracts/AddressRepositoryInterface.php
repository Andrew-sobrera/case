<?php

namespace App\Contracts;

use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

interface AddressRepositoryInterface
{
    public function getAll(): Collection;

    public function getByUserId(int $userId): Collection;

    public function findById(int $id): ?Address;

    public function create(array $data): Address;

    public function update(Address $address, array $data): Address;

    public function delete(Address $address): bool;
}
