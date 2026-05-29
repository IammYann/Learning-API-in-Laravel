<?php

namespace App\Providers;

use App\Events\ProductCreated;
use App\Events\ProductUpdated;
use App\Events\ProductDeleted;
use App\Listeners\SendProductNotification;
use App\Listeners\InvalidateProductCache;
use App\Listeners\HandleProductDeletion;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        ProductCreated::class => [
            SendProductNotification::class,
        ],
        ProductUpdated::class => [
            InvalidateProductCache::class,
        ],
        ProductDeleted::class => [
            HandleProductDeletion::class,
        ],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
