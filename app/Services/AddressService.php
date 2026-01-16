<?php

namespace App\Services;

use App\Contracts\AddressRepositoryInterface;
use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

class AddressService
{
    public function __construct(
        private AddressRepositoryInterface $addressRepository
    ) {}

    public function getAllAddresses(): Collection
    {
        return $this->addressRepository->getAll();
    }

    public function getUserAddresses(int $userId): Collection
    {
        return $this->addressRepository->getByUserId($userId);
    }

    public function getAddressById(int $id): ?Address
    {
        return $this->addressRepository->findById($id);
    }

    public function createAddress(array $data): Address
    {
        if (isset($data['cep'])) {
            $data['cep'] = preg_replace('/[^0-9]/', '', $data['cep']);
        }

        return $this->addressRepository->create($data);
    }

    public function updateAddress(Address $address, array $data): Address
    {
        if (isset($data['cep'])) {
            $data['cep'] = preg_replace('/[^0-9]/', '', $data['cep']);
        }

        return $this->addressRepository->update($address, $data);
    }

    public function deleteAddress(Address $address): bool
    {
        return $this->addressRepository->delete($address);
    }
}
