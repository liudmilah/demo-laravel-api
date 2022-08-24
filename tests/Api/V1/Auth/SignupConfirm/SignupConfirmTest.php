<?php
declare(strict_types=1);

namespace Tests\Api\V1\Auth\SignupConfirm;

use Illuminate\Auth\Notifications\VerifyEmail;
use Tests\ApiTestCase;

final class SignupConfirmTest extends ApiTestCase
{
    public function testSuccess()
    {
        $response = $this->get($this->getVerificationLink(TestSeeder::WAITING_USER_ID));

        $response->assertStatus(200)
            ->assertSeeText('');
    }

    public function testConfirmTwice()
    {
        $uri = $this->getVerificationLink(TestSeeder::WAITING_USER_ID);

        $response = $this->get($uri);

        $response->assertStatus(200)
            ->assertSeeText('');

        $response = $this->get($uri);

        $response->assertStatus(500);
    }

    public function testConfirmNonExistentUser()
    {
        $this->markTestIncomplete();
    }

    public function testConfirmInvalidHash()
    {
        $this->markTestIncomplete();
    }

    private function getVerificationLink(string $id): string
    {
        return (new VerifyEmail())
            ->toMail($this->getUser($id))
            ->actionUrl;
    }
}
