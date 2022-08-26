<?php

namespace Tests\Api\V1\Card\DeleteCard;

use Tests\ApiTestCase;

class DeleteCardTest extends ApiTestCase
{
    private const URI = '/api/v1/cards/%s';
    private const GET_URI = '/api/v1/cards?boardId=%s';

    public function testSuccess()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->delete($this->buildUrl(self::URI, TestSeeder::CARD_ID));
        $response->assertStatus(200);

        $response = $this->get($this->buildUrl(self::GET_URI, TestSeeder::BOARD_ID));
        $response->assertStatus(200)->assertExactJson([]);
    }

    public function testInvalidCardIdFormat()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->delete($this->buildUrl(self::URI, 'invalid-card-id'));

        $response->assertStatus(500);
    }

    public function testNonExistentCard()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->delete($this->buildUrl(self::URI, 'dcfc204a-4c75-0000-8431-4d3f02e00000'));

        $response->assertStatus(404);
    }

    public function testGuest()
    {
        $response = $this->delete($this->buildUrl(self::URI, TestSeeder::CARD_ID), $this->getPayload());

        $response->assertStatus(401);
    }
}
