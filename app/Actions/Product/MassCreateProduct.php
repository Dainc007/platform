<?php

namespace App\Actions\Product;

use App\Jobs\MassCreateProductJob;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class MassCreateProduct
{
    public static function createOrUpdate(array $records, array $uniqueColumns, $columnsToUpdate)
    {
        return Product::upsert($records, $uniqueColumns, $columnsToUpdate);
    }

    public static function fromCsvFile($data): void
    {
        try {
            MassCreateProductJob::dispatch($data)->onQueue('massCreateProduct');
        } catch (\Exception $e) {
            Log::error('Error processing records: ' . $e->getMessage());

        }
    }

}
