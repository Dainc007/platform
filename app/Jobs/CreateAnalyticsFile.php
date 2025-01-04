<?php

namespace App\Jobs;

use App\Actions\Contractor\CreateContractor;
use App\Models\Brand;
use App\Models\Contractor;
use App\Models\File;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CreateAnalyticsFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 2400;
    public int $tries = 10;
    public int $retryAfter = 60;
    public array $data;
    public Brand $brand;

    public function __construct($data)
    {
        $this->data = $data;
        $brandId = $data[0]['brand_id'];
        $this->brand = Brand::findOrFail($brandId);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->processForXlsx();
        } catch (Exception $e) {
            Log::error('Error creating analytics file: ' . $e->getMessage());
        }
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    private function processForXlsx(): void
    {
        $brandName = $this->brand->name;
        $fileName = now()->format('Y-m-d_H-i-s') . "($brandName)" . '.xlsx';
        $path = 'public/' . $fileName;

        $contractor = CreateContractor::handle('Analytics');
        $file = new File([
            'path' => $path,
            'fileable_id' => $contractor->id,
            'fileable_type' => Contractor::class,
            'status' => 'pending'
        ]);
        $file->save();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($brandName);

        $sheet->setCellValue('A1', 'code');
        $sheet->setCellValue('B1', 'brand');
        $sheet->setCellValue('C1', 'partio_price');
        $sheet->setCellValue('D1', 'offer_price');
        $sheet->setCellValue('E1', 'difference');
        $sheet->setCellValue('F1', 'percentage');

        foreach ($this->data as $key => $row) {
            $sheet->setCellValue('A' . ($key + 2), $row['code']);
            $sheet->setCellValue('B' . ($key + 2), $brandName);
            $sheet->setCellValue('C' . ($key + 2), number_format($row['partio_price'] / 100, 2));
            $sheet->setCellValue('D' . ($key + 2), number_format($row['price_from_file'] / 100, 2));
            $sheet->setCellValue('E' . ($key + 2), number_format($row['price_difference'] / 100, 2));
            $sheet->setCellValue('F' . ($key + 2), number_format($row['price_difference_percentage'], 1));
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/public/' . $fileName));

        $file->update(['status' => 'ready']);
    }

    private function proccessForCsv()
    {
        $brandName = $this->brand->name;
        $fileName = now()->format('Y-m-d_H-i-s') . "($brandName)" . '.csv';
        $path = 'public/' . $fileName;

        Storage::put($path, '');

        $handle = fopen(Storage::path($path), 'w');

        $contractor = CreateContractor::handle('Analytics');
        $file = new File([
            'path' => $path,
            'fileable_id' => $contractor->id,
            'fileable_type' => Contractor::class,
            'status' => 'pending'
        ]);
        $file->save();

        fputcsv($handle, ['code', 'brand', 'partio_price', 'offer_price', 'difference', 'percentage']); // Column headers

        foreach ($this->data as $key => $row) {
            $data = [
                $row['code'],
                $brandName,
                number_format($row['partio_price'] / 100, 2),
                number_format($row['price_from_file'] / 100, 2),
                number_format($row['price_difference'] / 100, 2),
                number_format($row['price_difference_percentage'], 1),
            ];
            fputcsv($handle, $data);
        }

        fclose($handle);
        $file->update(['status' => 'ready']);
    }
}
