<?php

namespace Tests\Api\V1;

use Tests\ApiTestCase;

class HomeTest extends ApiTestCase
{
    private const URI = '/api/v1';

    public function testHomeSuccess()
    {
        $response = $this->get(self::URI);

        $response->assertStatus(200)
            ->assertExactJson([ 'success' => true ]);
    }
}
