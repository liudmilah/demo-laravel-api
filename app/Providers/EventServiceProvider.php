<?php

namespace App\Providers;

use App\Domain\Board\Events\BoardCreated;
use App\Domain\Board\Listeners\BoardCreatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BoardCreated::class => [
            BoardCreatedListener::class,
        ],
    ];

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
