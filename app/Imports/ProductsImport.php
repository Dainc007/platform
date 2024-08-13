<?php

namespace App\Imports;

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
        return Product::updateOrCreate(
            [
                'code' => $row['reference_number'],
                'contractor_id' => $this->contractorId
            ],
            [
                'code' => $row['reference_number'],
                'price' => (int) str_replace(',', '', $row['price_offer']),
                'currency_id' => $this->currencyId,
                'contractor_id' => $this->contractorId,
                'file_id'       => $this->fileId,
                'brand_id'      => $this->brandId
            ]
        );
    }
}
