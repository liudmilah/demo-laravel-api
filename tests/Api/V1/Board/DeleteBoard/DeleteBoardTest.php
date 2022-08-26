<?php

namespace Tests\Api\V1\Board\DeleteBoard;

use Tests\ApiTestCase;

class DeleteBoardTest extends ApiTestCase
{
    private const URI = '/api/v1/boards/%s';
    private const GET_URI = '/api/v1/boards/%s';

    public function testSuccess()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->delete($this->buildUrl(self::URI, TestSeeder::BOARD_ID));
        $response->assertStatus(200);

        $response = $this->get($this->buildUrl(self::GET_URI, TestSeeder::BOARD_ID));
        $response->assertStatus(404);
    }

    public function testInvalidBoardIdFormat()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->delete($this->buildUrl(self::URI, 'invalid-board-id'));

        $response->assertStatus(500);
    }

    public function testNonExistentBoard()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->delete($this->buildUrl(self::URI, 'dcfc204a-4c75-4152-8431-4d3f02e7a000'));

        $response->assertStatus(404);
    }

    public function testGuest()
    {
        $response = $this->delete($this->buildUrl(self::URI, TestSeeder::BOARD_ID), $this->getPayload());

        $response->assertStatus(401);
    }
}
