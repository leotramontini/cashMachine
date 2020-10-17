<?php


namespace Tests\Unit\Controllers;

use App\Models\AccountType;
use Tests\TestCase;
use App\Models\User;

class AccountControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->baseResource = '/api/accounts';
    }

    public function testStore()
    {
        $user = User::factory()->create();
        $accountType = AccountType::factory()->create();
        $balance = $this->faker->randomDigitNotNull;

        $response = $this->json('POST', $this->baseResource, [
            'balance'           => $balance,
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ]);

        $response->assertJson([
            'balance'           => $balance,
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ])->assertStatus(200);
    }

    public function testStoreFail()
    {
        $user = User::factory()->create();
        $accountType = AccountType::factory()->create();

        $response = $this->json('POST', $this->baseResource, [
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ]);

        $response->assertJson([
            'message' => 'The balance field is required.'
        ])->assertStatus(422);
    }
}
