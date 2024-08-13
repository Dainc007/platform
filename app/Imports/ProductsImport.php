<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{

    protected int $contractorId;
    protected int $currencyId;
    protected int $fileId;
    protected int $brandId;

    public function __construct($contractorId, $currencyId, $fileId, $brandId)
    {
        $this->contractorId = $contractorId;
        $this->currencyId   = $currencyId;
        $this->fileId       = $fileId;
        $this->brandId      = $brandId;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function model(array $row)
    {
        $price = $row['price_offer'] ?? $row['price_net_eur'];

        if(isset($row['brand'])) {
            $brand = Brand::firstOrCreate(['name' => $row['brand']]);
        }

        return Product::updateOrCreate(
            [
                'code' => $row['reference_number'] ?? $row['sku'],
                'contractor_id' => $this->contractorId
            ],
            [
                'code' => $row['reference_number'] ?? $row['sku'],
                'price' => (int) str_replace(',', '', $price),
                'currency_id' => $this->currencyId,
                'contractor_id' => $this->contractorId,
                'file_id'       => $this->fileId,
                'brand_id'      => $brand?->id ?? $this->brandId,
                'quantity'      => $row['qty'] ?? 1
            ]
        );
    }
}
