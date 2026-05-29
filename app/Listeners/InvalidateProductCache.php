<?php

namespace App\Listeners;

use App\Events\ProductUpdated;

class InvalidateProductCache
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductUpdated $event): void
    {
        // Log the product update
        \Log::info('Product updated: ' . $event->product->name);
        
        // Cache is already cleared in the controller, but you could add additional logic here
        // For example: send admin notification, update search index, etc.
    }
}
