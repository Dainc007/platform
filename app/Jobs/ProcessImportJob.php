<?php

namespace App\Jobs;

use App\Models\Brand;
use App\Services\FileService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public int $timeout = 2400;
    public int $tries = 10;

    public int $skipHeaders = 1;
    public int $chunkSize = 2500;
    public array $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fileService = new FileService($this->data['path']);
        $headers = $fileService->getHeaders();
        $fileService->getCollection()->skip($this->skipHeaders)->chunk($this->chunkSize)->each(
            function ($chunk) use ($headers) {
                $records = $chunk->map(function ($row) use ($headers) {
                    return self::formatRow($row, $headers);
                });
                $records = $records->toArray();
            ProcessTemporaryProductImportJob::dispatch($records)->onQueue('analytics');
        });
    }

    private function formatRow(array $row, $headers): array
    {
        return [
        "code" => $row[array_search('code', $headers)],
            "price" => self::formatPrice($row[array_search('price', $headers)]),
            'brand_id' => (int)$this->data['brand_id'],
            'currency_id' => (int)$this->data['currency_id'],
            'contractor_id' => (int)$this->data['contractor_id'],
            'file_id' => $this->data['file_id'],
        ];
    }


    private function formatPrice($price): int
    {
        return (int)str_replace([' ', ','], '', $price) ?? 0;
    }
}
