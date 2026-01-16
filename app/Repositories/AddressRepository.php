<?php

namespace App\Repositories;

use App\Contracts\AddressRepositoryInterface;
use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

class AddressRepository implements AddressRepositoryInterface
{
    public function getAll(): Collection
    {
        return Address::all();
    }

    public function getByUserId(int $userId): Collection
    {
        return Address::where('user_id', $userId)->get();
    }

    public function findById(int $id): ?Address
    {
        return Address::find($id);
    }

    public function create(array $data): Address
    {
        return Address::create($data);
    }

    public function update(Address $address, array $data): Address
    {
        $address->update($data);
        return $address->fresh();
    }

    public function delete(Address $address): bool
    {
        return $address->delete();
    }
}
