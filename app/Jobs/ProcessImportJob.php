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

    public int $skipHeaders;
    public int $chunkSize;
    public string $filePath;
    public array $headers;

    public $brands;
    public ?int $lastProcessedBrandId = null;

    public function __construct(string $filePath, int $skipHeaders = 1, int $chunkSize = 2500)
    {
        $this->filePath = $filePath;
        $this->brands = Brand::orderBy('id')->pluck('name', 'id')->toArray();

        $this->skipHeaders = $skipHeaders;
        $this->chunkSize = $chunkSize;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fileService = new FileService($this->filePath);
        $this->headers = $fileService->getHeaders();
        $fileService->getCollection()->skip($this->skipHeaders)->chunk($this->chunkSize)->each(function ($chunk) {
            $records =  $chunk->map(function ($row) {
                return $this->formatRow($row);
            });
            $records = $records->toArray();
            ProcessProductImportJob::dispatch($records)->onQueue('importProducts');
        });
    }

    private function formatRow(array $row): array
    {
        return [
            "code" => $row[array_search('code', $this->headers)],
            "price" => $this->formatPrice($row[array_search('price', $this->headers)]),
            'brand_id' => $this->formatBrandId($row[array_search('brand', $this->headers)]),
            'currency_id' => 1
        ];
    }

    private function formatBrandId(string $brandName): int
    {
        if($this->lastProcessedBrandId && $this->brands[$this->lastProcessedBrandId] == $brandName ){
            return $this->lastProcessedBrandId;
        }

        if (in_array($brandName, $this->brands)) {
            $this->lastProcessedBrandId = array_search($brandName, $this->brands);
        } else {
            $this->lastProcessedBrandId = (Brand::firstOrCreate(['name' => $brandName]))->id;
            $this->brands = Brand::orderBy('id')->pluck('name', 'id')->toArray();
        }

        return $this->lastProcessedBrandId;
    }

    private function formatPrice($price): int
    {
        return (int)str_replace([' ', ','], '', $price) ?? 0;
    }
}
