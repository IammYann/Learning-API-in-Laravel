<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class GenerateInvoicePDF implements ShouldQueue
{
    use Queueable;

    protected $product;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $pdf = Pdf::loadView('invoices.product_invoice', ['product' => $this->product]);

            // Ensure directory exists
            $directory = 'invoices';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            $filename = $directory . '/product_' . $this->product->id . '_' . time() . '.pdf';
            Storage::put($filename, $pdf->output());

            \Log::info('Invoice PDF generated for product: ' . $this->product->name . ' at ' . $filename);
        } catch (\Exception $e) {
            \Log::error('Failed to generate invoice PDF: ' . $e->getMessage());
        }
    }
}