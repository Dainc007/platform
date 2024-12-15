<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\TemporaryProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class PrepareProductComparison implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 2400;
    public int $tries = 10;

    public int $chunkSize = 2500;
    public array $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        $codes = TemporaryProduct::where('brand_id', $this->data['brand_id'])->pluck('code')->toArray();
        Product::where('brand_id', $this->data['brand_id'])->whereIn('file_id', $this->data['files'])->whereIn('code', $codes)->select([
            'code', 'price', 'currency_id', 'contractor_id', 'file_id', 'brand_id', 'quantity', 'type'
        ])->chunk(1000, function ($products) {
            ProcessTemporaryProductImportJob::dispatch($products->toArray())->onQueue('analytics');
        });

        CreateAnalyticsFile::dispatch($this->getResults()->toArray())->onQueue('analytics');
    }

    private function getResults()
    {
        return TemporaryProduct::from('temporary_products as tp1')
            ->join('temporary_products as tp2', function ($join) {
                $join->on('tp1.code', '=', 'tp2.code')
                    ->on('tp1.brand_id', '=', 'tp2.brand_id')
                    ->where('tp1.contractor_id', '=', 42)
                    ->where('tp2.contractor_id', '<>', 42)
                    ->whereNotNull('tp1.contractor_id')
                    ->whereNotNull('tp2.contractor_id');
            })
            ->select(
                'tp1.code',
                'tp1.brand_id',
                'tp1.contractor_id as analyse_id',
                'tp1.price as price_from_file',
                'tp2.contractor_id as partio_contractor_id',
                'tp2.price as partio_price',
                DB::raw('ABS(tp1.price - tp2.price) as price_difference'),
                DB::raw('((tp1.price - tp2.price) / tp1.price) * 100 as price_difference_percentage')
            )
            ->orderBy('tp1.code')
            ->orderBy('tp1.brand_id')
            ->orderBy('tp1.contractor_id')
            ->get();
    }
}
