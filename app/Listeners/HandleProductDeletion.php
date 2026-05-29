<?php

namespace App\Listeners;

use App\Events\ProductDeleted;

class HandleProductDeletion
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
    public function handle(ProductDeleted $event): void
    {
        // Log the product deletion
        \Log::info('Product deleted: ' . $event->product->name);
        
        // Cache is already cleared in the controller, but you could add additional logic here
        // For example: archive the product, notify admins, clean up related data, etc.
    }
}
