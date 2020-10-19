<?php


namespace Tests\Unit\Controllers;

use App\Models\Account;
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

    public function testDeposit()
    {
        $user = User::factory()->create();
        $accountType = AccountType::factory()->create();

        $account = Account::factory()->create([
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ]);

        $depositValue = $this->faker->numberBetween(10, 100);

        $response = $this->json('PUT', $this->baseResource . '/' . $account->id . '/deposit', [
            'value' => $depositValue
        ]);

        $response->assertJson([
            'balance'           => ($account->balance + $depositValue),
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ])->assertStatus(200);
    }

    public function testDepositFail()
    {
        $user = User::factory()->create();
        $accountType = AccountType::factory()->create();

        $account = Account::factory()->create([
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ]);

        $depositValue = $this->faker->numberBetween(10, 100);

        $response = $this->json('PUT', $this->baseResource . '/' . ($account->id + $this->faker->randomDigitNotNull) . '/deposit', [
            'value' => $depositValue
        ]);

        $response->assertJson([
            'message' => 'Account not found'
        ])->assertStatus(404);
    }

    public function testDepositFailValidation()
    {
        $user = User::factory()->create();
        $accountType = AccountType::factory()->create();

        $account = Account::factory()->create([
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ]);

        $response = $this->json('PUT', $this->baseResource . '/' . ($account->id + $this->faker->randomDigitNotNull) . '/deposit');

        $response->assertJson([
            'message' => 'The value field is required.'
        ])->assertStatus(422);
    }

    public function testWithdrawWith150()
    {
        $user = User::factory()->create();
        $accountType = AccountType::factory()->create();

        $balance = 150;

        $account = Account::factory()->create([
            'balance'           => $balance,
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ]);

        $response = $this->json('PUT', $this->baseResource . '/' . $account->id . '/withdraw', [
            'value' => $balance
        ]);

        $response->assertJson([
            100 => 1,
            50  => 1
        ])->assertStatus(200);
    }

    public function testWithdrawWith60()
    {
        $user = User::factory()->create();
        $accountType = AccountType::factory()->create();

        $balance = 60;

        $account = Account::factory()->create([
            'balance'           => $balance,
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ]);

        $response = $this->json('PUT', $this->baseResource . '/' . $account->id . '/withdraw', [
            'value' => $balance
        ]);

        $response->assertJson([
            20 => 3
        ])->assertStatus(200);
    }

    public function testWithdrawValueSmallerThanMinimum()
    {
        $user = User::factory()->create();
        $accountType = AccountType::factory()->create();

        $balance = 15;

        $account = Account::factory()->create([
            'balance'           => $balance,
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ]);

        $response = $this->json('PUT', $this->baseResource . '/' . $account->id . '/withdraw', [
            'value' => $balance
        ]);

        $response->assertJson([
            'message' => 'The value must be at least 20.'
        ])->assertStatus(422);
    }

    public function testWithdrawValueBiggerThanBalance()
    {
        $user = User::factory()->create();
        $accountType = AccountType::factory()->create();

        $balance = 10;

        $account = Account::factory()->create([
            'balance'           => $balance,
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ]);

        $response = $this->json('PUT', $this->baseResource . '/' . $account->id . '/withdraw', [
            'value' => 20
        ]);

        $response->assertJson([
            'message' => 'Value is bigger than account balance'
        ])->assertStatus(404);
    }

    public function testWithdrawValueCompatibleWithBanknotes()
    {
        $user = User::factory()->create();
        $accountType = AccountType::factory()->create();

        $balance = 75;

        $account = Account::factory()->create([
            'balance'           => $balance,
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ]);

        $response = $this->json('PUT', $this->baseResource . '/' . $account->id . '/withdraw', [
            'value' => $balance
        ]);

        $response->assertJson([
            'message' => 'Value compatible with banknotes'
        ])->assertStatus(404);
    }

    public function testWithdrawNotFoundAccount()
    {
        $user = User::factory()->create();
        $accountType = AccountType::factory()->create();

        $account = Account::factory()->create([
            'user_id'           => $user->id,
            'account_type_id'   => $accountType->id
        ]);

        $depositValue = $this->faker->numberBetween(30, 100);

        $response = $this->json('PUT', $this->baseResource . '/' . ($account->id + $this->faker->randomDigitNotNull) . '/withdraw', [
            'value' => $depositValue
        ]);

        $response->assertJson([
            'message' => 'Account not found'
        ])->assertStatus(404);
    }
}
