<?php
declare(strict_types=1);

namespace Tests;

use App\Domain\Id;
use App\Domain\User\User;
use App\Domain\User\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

abstract class ApiTestCase extends TestCase
{
    use RefreshDatabase;

    protected string $baseUri = '/api/v1';
    protected ?array $payload = null;
    protected ?bool $hasSeeder = null;

    public function setUp(): void
    {
        parent::setUp();

        $dir = $this->getRunningTestDir();
        if (file_exists($dir.'/TestSeeder.php')) {
            $this->seed($this->getRunningTestNamespace().'\TestSeeder');
        }
    }

    protected function getPayload(): array
    {
        if (is_null($this->payload)) {
            if (file_exists($file = $this->getRunningTestDir() . '/payload.php')) {
                $this->payload = require $file;
            } else {
                $this->payload = [];
            }
        }

        return $this->payload;
    }

    protected function authorize(string $userId): void
    {
        Sanctum::actingAs($this->getUser($userId), ['*']);
    }

    protected function getUser(string $id): User
    {
        $users = $this->app->make(UserRepository::class);

        /** @var User $user */
        return $users->findOneById(new Id($id));
    }

    private function getRunningTestDir(): string
    {
        return dirname((new \ReflectionClass($this))->getFileName());
    }

    private function getRunningTestNamespace(): string
    {
        return (new \ReflectionClass($this))->getNamespaceName();
    }
}
