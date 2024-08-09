<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{

    protected int $contractorId;
    protected int $currencyId;
    protected int $fileId;

    public function __construct($contractorId, $currencyId, $fileId)
    {
        $this->contractorId = $contractorId;
        $this->currencyId   = $currencyId;
        $this->fileId       = $fileId;

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
                'file_id'       => $this->fileId
            ]
        );
    }
}
