<?php

namespace App\Jobs;

use App\Models\TemporaryProduct;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTemporaryProductImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public int $timeout = 2400;
    public int $tries = 10;

    public array $records;
    public function __construct(array $records)
    {
        $this->records = $records;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        return TemporaryProduct::upsert($this->records, ["code", 'brand_id'], ['price']);
    }
}
