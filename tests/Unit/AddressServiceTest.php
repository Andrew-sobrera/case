<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\User;
use App\Repositories\AddressRepository;
use App\Services\AddressService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AddressService $addressService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->addressService = new AddressService(new AddressRepository());
    }

    public function test_can_get_all_addresses(): void
    {
        $user = User::factory()->create();
        Address::factory()->count(3)->create(['user_id' => $user->id]);

        $addresses = $this->addressService->getAllAddresses();

        $this->assertCount(3, $addresses);
    }

    public function test_can_get_user_addresses(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Address::factory()->count(2)->create(['user_id' => $user1->id]);
        Address::factory()->create(['user_id' => $user2->id]);

        $addresses = $this->addressService->getUserAddresses($user1->id);

        $this->assertCount(2, $addresses);
    }

    public function test_can_create_address_with_cep_formatting(): void
    {
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'logradouro' => 'Test Street',
            'numero' => '123',
            'bairro' => 'Test Neighborhood',
            'cep' => '12345-678',
        ];

        $address = $this->addressService->createAddress($data);

        $this->assertEquals('12345678', $address->cep);
    }

    public function test_can_get_address_by_id(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);

        $foundAddress = $this->addressService->getAddressById($address->id);

        $this->assertNotNull($foundAddress);
        $this->assertEquals($address->id, $foundAddress->id);
    }

    public function test_can_update_address(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'logradouro' => 'Original Street'
        ]);

        $updatedAddress = $this->addressService->updateAddress($address, ['logradouro' => 'Updated Street']);

        $this->assertEquals('Updated Street', $updatedAddress->logradouro);
    }

    public function test_can_delete_address(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);

        $result = $this->addressService->deleteAddress($address);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }

    public function test_cep_formatting_removes_non_numeric_characters(): void
    {
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'logradouro' => 'Test Street',
            'numero' => '123',
            'bairro' => 'Test Neighborhood',
            'cep' => '12.345-678',
        ];

        $address = $this->addressService->createAddress($data);

        $this->assertEquals('12345678', $address->cep);
    }
}
