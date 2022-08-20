<?php

namespace Tests\Api\V1;

use Tests\ApiTestCase;

class HomeTest extends ApiTestCase
{
    public function testHomeSuccess()
    {
        $response = $this->get($this->baseUri);

        $response->assertStatus(200)
            ->assertExactJson([ 'success' => true ]);
    }
}
