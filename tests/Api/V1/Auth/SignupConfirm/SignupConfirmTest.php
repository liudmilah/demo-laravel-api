<?php
declare(strict_types=1);

namespace Tests\Api\V1\Auth\SignupConfirm;

use App\Domain\Id;
use App\Domain\User\User;
use App\Domain\User\UserRepository;
use Illuminate\Auth\Notifications\VerifyEmail;
use Tests\ApiTestCase;

final class SignupConfirmTest extends ApiTestCase
{
    public function testSuccess()
    {
        $response = $this->get(
            $this->getVerificationLink(TestSeeder::WAITING_USER_ID)
        );

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
        $notification = new VerifyEmail();

        $users = $this->app->make(UserRepository::class);

        /** @var User $user */
        $user = $users->findOneById(new Id($id));

        return $notification->toMail($user)->actionUrl;
    }
}
