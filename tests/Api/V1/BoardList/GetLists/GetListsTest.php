<?php

namespace Tests\Api\V1\BoardList\GetLists;

use Tests\ApiTestCase;

class GetListsTest extends ApiTestCase
{
    private const URI = '/api/v1/lists?boardId=%s';

    public function testSuccess()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->get($this->buildUrl(self::URI, TestSeeder::BOARD_ID));

        $response->assertStatus(200)
            ->assertExactJson(
                [
                    [
                        'id' => TestSeeder::LIST1_ID,
                        'name' => TestSeeder::LIST1_NAME,
                        'sequence' => TestSeeder::LIST1_SEQ,
                    ],
                    [
                        'id' => TestSeeder::LIST2_ID,
                        'name' => TestSeeder::LIST2_NAME,
                        'sequence' => TestSeeder::LIST2_SEQ,
                    ],
                ]
            );
    }

    public function testEmptyBoard()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->get($this->buildUrl(self::URI, ''));

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'The board id field is required.']);
    }

    public function testNonExistentBoard()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->get($this->buildUrl(self::URI, 'dcfc204a-4c75-4152-8431-4d3f02e70000'));

        $response->assertStatus(200)->assertExactJson([]);
    }

    public function testInvalidBoard()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->get($this->buildUrl(self::URI, 'invalid-board-id'));

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'The board id must be a valid UUID.']);
    }

    public function testGuest()
    {
        $response = $this->get(self::URI);

        $response->assertStatus(401);
    }
}
