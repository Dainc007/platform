<?php

namespace App\Actions\Product;

use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class CreateProduct
{
    public static function fromExcelFile($data, $file): void
    {
        Excel::queueImport(new ProductsImport($data['contractor_id'], $data['currency_id'], $file->id, $data['brand_id'], $data['type']), $file->path);
    }
}
