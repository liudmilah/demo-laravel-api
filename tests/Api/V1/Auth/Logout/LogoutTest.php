<?php
declare(strict_types=1);

namespace Tests\Api\V1\Auth\Logout;

use Tests\ApiTestCase;

final class LogoutTest extends ApiTestCase
{
    private const LOGOUT_URI = '/api/v1/auth/logout';
    private const GET_USER_URI = '/api/v1/user';

    public function testSuccess()
    {
        $this->authorize(TestSeeder::USER_ID);
        $response = $this->get(self::LOGOUT_URI);
        $response->assertStatus(200);

        $response = $this->get(self::GET_USER_URI);
        $response->assertStatus(200); // todo must be 401
    }
}
