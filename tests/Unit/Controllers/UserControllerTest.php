<?php


namespace Tests\Unit\Controllers;


use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->baseResource = '/api/users';
    }

    public function testStore()
    {
        $user = [
            'name'      => $this->faker->name,
            'birthday'  => $this->faker->date(),
            'cpf'       => $this->faker->numberBetween(11111111111, 99999999999)
        ];

        $response = $this->json('POST', $this->baseResource, $user);

        $response->assertJson($user)
            ->assertStatus(200);
    }

    public function testStoreFailValidation()
    {
        $user = [
            'name'      => $this->faker->name,
            'birthday'  => $this->faker->date(),
            'cpf'       => $this->faker->numberBetween(1111111111, 9999999999)
        ];

        $response = $this->json('POST', $this->baseResource, $user);

        $response->assertStatus(422);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();

        $response = $this->json('DELETE', $this->baseResource . '/' . $user->id);

        $response->assertJson([
            'message' => 'User delete with success'
        ])
            ->assertStatus(200);
    }

    public function testDestroyFail()
    {
        $user = User::factory()->create();

        $response = $this->json('DELETE', $this->baseResource . '/' . ($user->id + $this->faker->randomDigitNotNull));

        $response->assertJson([
            'message' => 'User not found'
        ])
            ->assertStatus(404);
    }
}
