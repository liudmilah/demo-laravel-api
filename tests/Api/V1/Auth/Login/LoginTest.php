<?php
declare(strict_types=1);

namespace Tests\Api\V1\Auth\Login;

use Tests\ApiTestCase;
use Tests\Helper;

final class LoginTest extends ApiTestCase
{
    private const URI = '/api/v1/auth/login';

    public function testSuccess()
    {
        $response = $this->post(self::URI, $this->getPayload());

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function testWaitingUser()
    {
        $response = $this->post(
            self::URI,
            Helper::replace($this->getPayload(), ['email' => TestSeeder::WAITING_USER_EMAIL]),
        );

        $response->assertStatus(500);
    }

    /**
     * @dataProvider validationErrors
     */
    public function testValidationErrors(array $payload, string $errorMessage)
    {
        $response = $this->post(self::URI, $payload);

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => $errorMessage]);
    }

    /**
     * @dataProvider domainErrors
     */
    public function testDomainErrors(array $payload)
    {
        $response = $this->post(self::URI, $payload);

        $response->assertStatus(500);
    }

    public function validationErrors(): array
    {
        return [
            'missing password' => [
                Helper::unset($this->getPayload(), ['password']),
                'The password field is required.'
            ],
            'invalid email format' => [
                Helper::replace($this->getPayload(), ['email' => 'xxxxxxx']),
                'The email must be a valid email address.'
            ],
            'missing email' => [
                Helper::unset($this->getPayload(), ['email']),
                'The email field is required.'
            ],
        ];
    }

    public function domainErrors(): array
    {
        return [
            'invalid password' => [
                Helper::replace($this->getPayload(), ['password' => 'xxxxxxx']),
            ],
            'invalid email' => [
                Helper::replace($this->getPayload(), ['email' => 'invalid@test.by']),
            ],
            'waiting user email' => [
                Helper::replace($this->getPayload(), ['email' => TestSeeder::WAITING_USER_EMAIL]),
            ],
        ];
    }
}
