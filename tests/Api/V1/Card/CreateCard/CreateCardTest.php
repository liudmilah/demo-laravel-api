<?php

namespace Tests\Api\V1\Card\CreateCard;

use Tests\ApiTestCase;
use Tests\Helper;

class CreateCardTest extends ApiTestCase
{
    private const URI = '/api/v1/cards';

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
            'empty name' => [
                Helper::replace($this->getPayload(), ['name' => '']),
                'The name field is required.'
            ],
            'long name' => [
                Helper::replace($this->getPayload(), ['name' => str_repeat('*', 101)]),
                'The name must not be greater than 100 characters.'
            ],
            'long description' => [
                Helper::replace($this->getPayload(), ['description' => str_repeat('*', 10001)]),
                'The description must not be greater than 10000 characters.'
            ],
            'empty boardId' => [
                Helper::replace($this->getPayload(), ['boardId' => '']),
                'The board id field is required.'
            ],
            'boardId not uuid' => [
                Helper::replace($this->getPayload(), ['boardId' => 'invalid-board-id']),
                'The board id must be a valid UUID.'
            ],
            'empty listId' => [
                Helper::replace($this->getPayload(), ['listId' => '']),
                'The list id field is required.'
            ],
            'listId not uuid' => [
                Helper::replace($this->getPayload(), ['listId' => 'invalid-list-id']),
                'The list id must be a valid UUID.'
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
                Helper::replace($this->getPayload(), ['boardId' => 'dcfc204a-0000-0000-0000-4d3f02e99999']),
                'List not found.',
            ],
            'list does not exist' => [
                Helper::replace($this->getPayload(), ['listId' => 'dcfc204a-0000-0000-0000-4d3f00000000']),
                'List not found.',
            ],
            'not unique sequence' => [
                Helper::replace($this->getPayload(), ['sequence' => TestSeeder::CARD_SEQ]),
                'Sequence is not unique.',
            ],
            'not unique name' => [
                Helper::replace($this->getPayload(), ['name' => TestSeeder::CARD_NAME]),
                'Name is not unique.',
            ],
        ];
    }
}
