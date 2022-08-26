<?php

namespace Tests\Api\V1\BoardList\CreateList;

use Tests\ApiTestCase;
use Tests\Helper;

class CreateListTest extends ApiTestCase
{
    private const URI = '/api/v1/lists';

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

    /**
     * @dataProvider domainErrors
     */
    public function testDomainErrors(array $payload, string $message)
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->post(self::URI, $payload);

        $response->assertStatus(409)
            ->assertJsonFragment(['message' => $message]);
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
                'Board not found.',
            ],
            'not unique sequence' => [
                Helper::replace($this->getPayload(), ['sequence' => TestSeeder::LIST_SEQ]),
                'List with this sequence already exists.',
            ],
            'not unique name' => [
                Helper::replace($this->getPayload(), ['name' => TestSeeder::LIST_NAME]),
                'List with this name already exists.',
            ],
        ];
    }
}
