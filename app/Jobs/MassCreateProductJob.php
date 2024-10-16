<?php

namespace App\Jobs;

use App\Services\FileService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MassCreateProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 2400;
    public int $tries = 10;
    public int $retryAfter = 60;

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
        $skipHeaders = 1;
        $chunkSize = 2500;

        $fileService->getCollection()->skip($skipHeaders)->chunk($chunkSize)->each(
            function ($chunk) use ($headers) {
                $records = $chunk->map(function ($row) use ($headers) {
                    return self::formatRow($row, $headers, $this->data);
                });
                $records = $records->toArray();
                ProductImportJob::dispatch($records)->onQueue('importProducts');
            }
        );
    }

    private static function formatRow(array $row, array $headers, $data): array
    {
        return [
            "code" => $row[array_search('code', $headers)],
            "price" => self::formatPrice($row[array_search('price', $headers)]),
            'brand_id' => (int)$data['brand_id'],
            'currency_id' => (int)$data['currency_id'],
            'contractor_id' => (int)$data['contractor_id'],
            'type' => $data['type'],
            'file_id' => $data['file_id'],
        ];
    }

    private static function formatPrice($price): int
    {
        return (int)str_replace([' ', ','], '', $price) ?? 0;
    }
}
