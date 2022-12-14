<?php

namespace Tests\Api\V1\Board\CreateBoard;

use Tests\ApiTestCase;
use Tests\Helper;

class CreateBoardTest extends ApiTestCase
{
    private const URI = '/api/v1/boards';

    public function testSuccess()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->post(self::URI, $this->getPayload());

        $response->assertStatus(201)
            ->assertJsonStructure(['id']);
    }

    /**
     * @dataProvider validationErrors
     */
    public function testValidationErrors(array $payload, string $errorMessage)
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->post(self::URI, $payload);

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => $errorMessage]);
    }

    public function testGuest()
    {
        $response = $this->post(self::URI, $this->getPayload());

        $response->assertStatus(401);
    }

    public function validationErrors(): array
    {
        return [
            'missing name' => [
                Helper::unset($this->getPayload(), ['name']),
                'The name field is required.'
            ],
            'empty name' => [
                Helper::replace($this->getPayload(), ['name' => null]),
                'The name field is required.'
            ],
            'long name' => [
                Helper::replace($this->getPayload(), ['name' => str_repeat('*', 101)]),
                'The name must not be greater than 100 characters.'
            ],
        ];
    }
}
