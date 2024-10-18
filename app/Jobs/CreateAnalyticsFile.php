<?php

namespace App\Jobs;

use App\Actions\Contractor\CreateContractor;
use App\Actions\File\CreateFile;
use App\Models\Contractor;
use App\Models\File;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CreateAnalyticsFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 2400;
    public int $tries = 10;
    public int $retryAfter = 60;
    public $collection;
    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fileName = now()->format('Y-m-d_H-i-s') . '.csv';
        $path = 'public/' . $fileName;

        Storage::put($path, '');

        $handle = fopen(Storage::path($path), 'w');

        $contractor = CreateContractor::handle('Analytics');
        $file = new File([
            'path' => $path,
            'fileable_id' => $contractor->id,
            'fileable_type' => Contractor::class,
            'status'    => 'pending'
        ]);
        $file->save();
        fputcsv($handle, ['code', 'brand', 'price', 'offer_price', 'difference', 'percentage' ]); // Nagłówki kolumn

        foreach ($this->collection as $key => $row) {
            $data = [
                $row['code'],
                $row['brand']['name'],
                number_format($row['product_price'] / 100, 2),
                number_format($row['temp_product_price'] / 100, 2),
                number_format($row['price_difference'] / 100, 2),
                number_format($row['price_difference_percentage'], 2),
            ];
            fputcsv($handle, $data);
        }
        fclose($handle);
        $file->status = 'ready';
        $file->save();
    }
}
