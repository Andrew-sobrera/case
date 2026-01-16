<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Services\AddressService;
use Illuminate\Http\JsonResponse;

class AddressController
{
    protected AddressService $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index(): JsonResponse
    {
        $addresses = $this->addressService->getAllAddresses();
        
        return response()->json([
            'status' => 'success',
            'data' => $addresses
        ], 200);
    }

    public function userAddresses(int $userId): JsonResponse
    {
        $addresses = $this->addressService->getUserAddresses($userId);
        
        return response()->json([
            'status' => 'success',
            'data' => $addresses
        ], 200);
    }

    public function store(StoreAddressRequest $request): JsonResponse
    {
        $address = $this->addressService->createAddress($request->validated());
        
        return response()->json([
            'status' => 'success',
            'message' => 'Address created successfully',
            'data' => $address
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $address = $this->addressService->getAddressById($id);
        
        if (!$address) {
            return response()->json([
                'status' => 'error',
                'message' => 'Address not found'
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $address
        ], 200);
    }

    public function update(UpdateAddressRequest $request, int $id): JsonResponse
    {
        $address = $this->addressService->getAddressById($id);
        
        if (!$address) {
            return response()->json([
                'status' => 'error',
                'message' => 'Address not found'
            ], 404);
        }
        
        $updatedAddress = $this->addressService->updateAddress($address, $request->validated());
        
        return response()->json([
            'status' => 'success',
            'message' => 'Address updated successfully',
            'data' => $updatedAddress
        ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $address = $this->addressService->getAddressById($id);
        
        if (!$address) {
            return response()->json([
                'status' => 'error',
                'message' => 'Address not found'
            ], 404);
        }
        
        $this->addressService->deleteAddress($address);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Address deleted successfully'
        ], 200);
    }
}
