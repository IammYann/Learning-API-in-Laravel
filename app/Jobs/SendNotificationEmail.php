<?php

namespace App\Jobs;

use App\Models\Product;
use App\Mail\ProductAddedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmail implements ShouldQueue
{
    use Queueable;

    protected $product;
    protected $userEmail;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product, string $userEmail)
    {
        $this->product = $product;
        $this->userEmail = $userEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->userEmail)->send(new ProductAddedMail($this->product));
    }
}
