<?php
declare(strict_types=1);

namespace Tests\Api\V1\Auth\SignupRequest;

use Tests\ApiTestCase;
use Tests\Helper;

final class SignupRequestTest extends ApiTestCase
{
    private const URI = '/api/v1/auth/signup';

    public function testSuccess()
    {
        $response = $this->post(
            self::URI,
            $this->getPayload()
        );

        $response->assertStatus(201)
            ->assertSeeText('');
    }

    public function testEmptyPayload()
    {
        $response = $this->post(self::URI, []);

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'The name field is required. (and 2 more errors)']);
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

    public function validationErrors(): array
    {
        return [
            'missing password confirmation' => [
                Helper::unset($this->getPayload(), ['password_confirmation']),
                'The password confirmation does not match.'
            ],
            'invalid password confirmation' => [
                Helper::replace($this->getPayload(), ['password_confirmation' => 'xxxxxxx']),
                'The password confirmation does not match.'
            ],
            'short password' => [
                Helper::replace($this->getPayload(), ['password' => 'xxxxxxx', 'password_confirmation' => 'xxxxxxx']),
                'The password must be at least 8 characters.'
            ],
            'missing password' => [
                Helper::unset($this->getPayload(), ['password']),
                'The password field is required.'
            ],
            'existing email' => [
                Helper::replace($this->getPayload(), ['email' => TestSeeder::EMAIL]),
                'The email has already been taken.'
            ],
            'invalid email' => [
                Helper::replace($this->getPayload(), ['email' => 'xxxxxxx']),
                'The email must be a valid email address.'
            ],
            'missing email' => [
                Helper::unset($this->getPayload(), ['email']),
                'The email field is required.'
            ],
            'missing name' => [
                Helper::unset($this->getPayload(), ['name']),
                'The name field is required.'
            ],
            'empty name' => [
                Helper::replace($this->getPayload(), ['name' => null]),
                'The name field is required.'
            ],
            'long name' => [
                Helper::replace($this->getPayload(), ['name' => str_repeat('*', 101)]),
                'The name must not be greater than 100 characters.'
            ],
            'short name' => [
                Helper::replace($this->getPayload(), ['name' => 'N']),
                'The name must be at least 2 characters.'
            ],
        ];
    }
}
