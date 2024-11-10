<?php

namespace App\Jobs;

use App\Models\Brand;
use App\Models\Product;
use App\Services\FileService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MassCreateProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 2400;
    public int $tries = 10;
    public int $retryAfter = 60;

    public array $data;

    public Collection $brands;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->brands = Brand::all();
    }

    /**
     * @param array $headers
     * @param array $row
     * @return int|mixed
     */
    public static function getQuantity(array $headers, array $row): mixed
    {
        $quantityIndex = array_search('qty', $headers);
        $quantity = $quantityIndex !== false ? $row[$quantityIndex] : 1;
        return $quantity;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fileService = new FileService($this->data['path']);
        $headers = $fileService->getHeaders();
        $chunkSize = 2500;

        $fileService->getCollection()->chunk($chunkSize)->each(
            function ($chunk) use ($headers) {
                $records = $chunk->map(function ($row) use ($headers) {
                    $this->processBaseOnType($row, $headers);
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
            'quantity' =>  self::getQuantity($headers, $row),
        ];
    }

    private static function formatPrice($price): int
    {
        return (int)str_replace([' ', ','], '', $price) ?? 0;
    }

    private function processBaseOnType($row, $headers): void
    {
        if($this->data['type'] !== Product::TYPE_STOCK) {
            return;
        }

        $brandName = $row[array_search('brand', $headers)];
        $brand = $this->brands->where('name', $brandName)->first() ?? Brand::updateOrCreate($data = ['name' => $brandName], $data);

        $this->data['brand_id'] = $brand->id;
    }
}
