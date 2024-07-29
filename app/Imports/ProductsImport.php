<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{

    protected $contractorId;
    protected $currencyId;


    public function __construct($contractorId, $currencyId)
    {
        $this->contractorId = $contractorId;
        $this->currencyId   = $currencyId;

    }


    public function model(array $row)
    {
        return new Product([
            'code' => $row['reference_number'],
            'price' => (int) str_replace(',', '', $row['price_offer']),
            'currency_id' => 4,
            'contractor_id' => $this->contractorId
        ]);
    }
}
