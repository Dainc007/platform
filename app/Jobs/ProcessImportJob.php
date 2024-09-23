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
    public int $skipHeaders;
    public FileService $fileService;
    public $brands;
    public Brand $lastProcessedBrand;
    public array $headers;
    public int $chunkSize;
    public int $tries = 10;
    public function __construct(string $filePath, int $skipHeaders = 1, int $chunkSize = 500)
    {
        $this->fileService = new FileService($filePath);
        $this->headers = $this->fileService->getHeaders();
        $this->brands = Brand::orderBy('id')->pluck('name', 'id')->toArray();
        $this->lastProcessedBrand = new Brand(['name' => 'test', 'id' => 999]);

        $this->skipHeaders = $skipHeaders;
        $this->chunkSize = $chunkSize;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->fileService->getCollection()->skip($this->skipHeaders)->chunk($this->chunkSize)->each(function ($chunk) {
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
        if ($brandName != $this->lastProcessedBrand->name) {
            if (in_array($brandName, $this->brands)) {
                $key = array_search($brandName, $this->brands);
            } else {
                $key = (Brand::firstOrCreate(['name' => $brandName]))->id;
                $this->brands = Brand::orderBy('id')->pluck('name', 'id')->toArray();
            }
        }

        return $key ?? $this->lastProcessedBrand->id;
    }

    private function formatPrice($price): int
    {
        return (int)str_replace([' ', ','], '', $price) ?? 0;
    }
}
