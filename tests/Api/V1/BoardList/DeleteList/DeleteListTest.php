<?php

namespace Tests\Api\V1\BoardList\DeleteList;

use Tests\ApiTestCase;

class DeleteListTest extends ApiTestCase
{
    private const URI = '/api/v1/lists/%s';
    private const GET_URI = '/api/v1/lists/%s';

    public function testSuccess()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->delete($this->buildUrl(self::URI, TestSeeder::LIST1_ID));
        $response->assertStatus(200);

        $response = $this->get($this->buildUrl(self::GET_URI, TestSeeder::LIST1_ID));
        $response->assertStatus(404);
    }

    public function testInvalidListIdFormat()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->delete($this->buildUrl(self::URI, 'invalid-list-id'));

        $response->assertStatus(500);
    }

    public function testNonExistentList()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->delete($this->buildUrl(self::URI, 'dcfc204a-4c75-0000-8431-4d3f02e00000'));

        $response->assertStatus(404);
    }

    public function testGuest()
    {
        $response = $this->delete($this->buildUrl(self::URI, TestSeeder::LIST1_ID), $this->getPayload());

        $response->assertStatus(401);
    }
}
