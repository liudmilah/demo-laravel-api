<?php

namespace Tests\Api\V1\BoardList\GetList;

use Tests\ApiTestCase;

class GetListTest extends ApiTestCase
{
    private const URI = '/api/v1/lists/%s';

    public function testSuccess()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->get($this->buildUrl(self::URI, TestSeeder::LIST_ID));

        $response->assertStatus(200)
            ->assertExactJson([
                'id' => TestSeeder::LIST_ID,
                'name' => TestSeeder::LIST_NAME,
                'sequence' => TestSeeder::LIST_SEQ,
            ]);
    }

    public function testInvalidListIdFormat()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->get($this->buildUrl(self::URI, 'invalid-list-id'));

        $response->assertStatus(500);
    }

    public function testNonExistentList()
    {
        $this->authorize(TestSeeder::USER_ID);

        $response = $this->get($this->buildUrl(self::URI, 'dcfc204a-4c75-4152-8431-4d3f02e7af6d'));

        $response->assertStatus(404);
    }

    public function testGuest()
    {
        $response = $this->get($this->buildUrl(self::URI, TestSeeder::LIST_ID));

        $response->assertStatus(401);
    }
}
