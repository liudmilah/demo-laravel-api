<?php

namespace Tests\Api\V1\Card\GetCards;

use Tests\ApiTestCase;

class GetCardsTest extends ApiTestCase
{
    private const URI = '/api/v1/cards?boardId=%s';

    public function testSuccess()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->get($this->buildUrl(self::URI, TestSeeder::BOARD_ID));

        $response->assertStatus(200)
            ->assertExactJson(
                [
                    TestSeeder::LIST1_ID => [
                        [
                            'id' => TestSeeder::CARD1_ID,
                            'name' => TestSeeder::CARD1_NAME,
                            'description' => TestSeeder::CARD1_DESCR,
                            'sequence' => TestSeeder::CARD1_SEQ,
                        ],
                        [
                            'id' => TestSeeder::CARD2_ID,
                            'name' => TestSeeder::CARD2_NAME,
                            'sequence' => TestSeeder::CARD2_SEQ,
                            'description' => TestSeeder::CARD2_DESCR,
                        ],
                    ],
                    TestSeeder::LIST2_ID => [
                        [
                            'id' => TestSeeder::CARD3_ID,
                            'name' => TestSeeder::CARD3_NAME,
                            'sequence' => TestSeeder::CARD3_SEQ,
                            'description' => TestSeeder::CARD3_DESCR,
                        ],
                    ]
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
