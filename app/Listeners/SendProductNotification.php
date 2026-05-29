<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Jobs\SendNotificationEmail;
use App\Jobs\GenerateInvoicePDF;

class SendProductNotification
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
    public function handle(ProductCreated $event): void
    {
        // Log the product creation
        \Log::info('Product created: ' . $event->product->name);

        // Dispatch the notification email job
        $userEmail = auth()->user() ? auth()->user()->email : 'admin@example.com';
        SendNotificationEmail::dispatch($event->product, $userEmail);

        // Dispatch the invoice PDF job
        GenerateInvoicePDF::dispatch($event->product);
    }
}
