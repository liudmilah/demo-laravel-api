<?php

namespace Tests\Api\V1\BoardList\UpdateList;

use Tests\ApiTestCase;
use Tests\Helper;

class UpdateListTest extends ApiTestCase
{
    private const URI = '/api/v1/lists/%s';
    private const GET_URI = '/api/v1/lists/%s';

    public function testSuccess()
    {
        $this->authorize(TestSeeder::USER_ID);

        $payload = $this->getPayload();

        $response = $this->put($this->buildUrl(self::URI, TestSeeder::LIST1_ID), $payload);
        $response->assertStatus(200);

        $response = $this->get($this->buildUrl(self::GET_URI, TestSeeder::LIST1_ID));
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $payload['name']]);
    }

    /**
     * @dataProvider validationErrors
     */
    public function testValidationErrors(array $payload, string $errorMessage)
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->put($this->buildUrl(self::URI, TestSeeder::LIST1_ID), $payload);

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => $errorMessage]);
    }

    /**
     * @dataProvider domainErrors
     */
    public function testDomainErrors(array $payload, string $message)
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->put($this->buildUrl(self::URI, TestSeeder::LIST1_ID), $payload);

        $response->assertStatus(409)
            ->assertJsonFragment(['message' => $message]);
    }

    public function testGuest()
    {
        $response = $this->put(
            $this->buildUrl(self::URI, TestSeeder::LIST1_ID),
            $this->getPayload()
        );

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
                Helper::replace($this->getPayload(), ['name' => '']),
                'The name field is required.'
            ],
            'long name' => [
                Helper::replace($this->getPayload(), ['name' => str_repeat('*', 101)]),
                'The name must not be greater than 100 characters.'
            ],
            'empty boardId' => [
                Helper::replace($this->getPayload(), ['boardId' => '']),
                'The board id field is required.'
            ],
            'boardId not uuid' => [
                Helper::replace($this->getPayload(), ['boardId' => 'invalid-board-id']),
                'The board id must be a valid UUID.'
            ],
            'empty sequence' => [
                Helper::replace($this->getPayload(), ['sequence' => null]),
                'The sequence field is required.'
            ],
            'sequence not int' => [
                Helper::replace($this->getPayload(), ['sequence' => 'string']),
                'The sequence must be an integer.'
            ],
        ];
    }

    public function domainErrors(): array
    {
        return [
            'board does not exist' => [
                Helper::replace($this->getPayload(), ['boardId' => 'dcfc204a-0000-0000-0000-4d3f02e7af6a']),
                'List not found.',
            ],
            'not unique sequence' => [
                Helper::replace($this->getPayload(), ['sequence' => TestSeeder::LIST2_SEQ]),
                'List with this sequence already exists.',
            ],
            'not unique name' => [
                Helper::replace($this->getPayload(), ['name' => TestSeeder::LIST2_NAME]),
                'List with this name already exists.',
            ],
        ];
    }
}
