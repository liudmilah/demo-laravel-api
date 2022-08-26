<?php

namespace Tests\Api\V1\Board\UpdateBoard;

use Tests\ApiTestCase;
use Tests\Helper;

class UpdateBoardTest extends ApiTestCase
{
    private const URI = '/api/v1/boards/%s';
    private const GET_URI = '/api/v1/boards/%s';

    public function testSuccess()
    {
        $this->authorize(TestSeeder::USER_ID);

        $payload = $this->getPayload();

        $response = $this->put($this->buildUrl(self::URI, TestSeeder::BOARD_ID), $payload);
        $response->assertStatus(200);

        $response = $this->get($this->buildUrl(self::GET_URI, TestSeeder::BOARD_ID));
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $payload['name']]);
    }

    /**
     * @dataProvider validationErrors
     */
    public function testValidationErrors(array $payload, string $errorMessage)
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->put($this->buildUrl(self::URI, TestSeeder::BOARD_ID), $payload);

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => $errorMessage]);
    }

    /**
     * @dataProvider domainErrors
     */
    public function testDomainErrors(array $payload, string $message)
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->put($this->buildUrl(self::URI, TestSeeder::BOARD_ID), $payload);

        $response->assertStatus(409)
            ->assertJsonFragment(['message' => $message]);
    }

    public function testGuest()
    {
        $response = $this->put($this->buildUrl(self::URI, TestSeeder::BOARD_ID), $this->getPayload());

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

    public function domainErrors(): array
    {
        return [
            'existing board name' => [
                Helper::replace($this->getPayload(), ['name' => TestSeeder::BOARD_NAME]),
                'Board name is not unique.',
            ],
        ];
    }
}
