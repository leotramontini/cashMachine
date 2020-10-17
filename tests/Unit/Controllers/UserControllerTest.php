<?php


namespace Tests\Unit\Controllers;


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
}
