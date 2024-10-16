<?php

namespace App\Jobs;

use App\Actions\Product\MassCreateProduct;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProductImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $records;
    public int $tries = 5; // Liczba prób
    public int $retryAfter = 60; // Czas w sekundach przed ponowną próbą
    public function __construct(array $records)
    {
        $this->records = $records;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            MassCreateProduct::createOrUpdate($this->records, [
                'code', 'contractor_id', 'brand_id', 'type'
            ], [
                'code', 'price', 'currency_id', 'contractor_id', 'file_id', 'brand_id', 'quantity', 'type'
            ]);
        } catch (\Exception $e) {
            Log::error('Error processing records: ' . $e->getMessage());
        }
    }
}
