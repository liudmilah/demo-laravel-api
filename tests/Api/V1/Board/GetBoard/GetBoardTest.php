<?php

namespace Tests\Api\V1\Board\GetBoard;

use Tests\ApiTestCase;

class GetBoardTest extends ApiTestCase
{
    private const URI = '/api/v1/boards/%s';

    public function testSuccess()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->get($this->buildUrl(self::URI, TestSeeder::BOARD_ID));

        $response->assertStatus(200)
            ->assertExactJson(['id' => TestSeeder::BOARD_ID, 'name' => TestSeeder::BOARD_NAME]);
    }

    public function testInvalidBoardIdFormat()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->get($this->buildUrl(self::URI, 'invalid-board-id'));

        $response->assertStatus(500);
    }

    public function testNonExistentBoard()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->get($this->buildUrl(self::URI, 'dcfc204a-4c75-4152-8431-4d3f02e7af6d'));

        $response->assertStatus(404);
    }

    public function testGuest()
    {
        $response = $this->get($this->buildUrl(self::URI, TestSeeder::BOARD_ID));

        $response->assertStatus(401);
    }
}
