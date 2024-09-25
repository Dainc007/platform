<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;

class FileService
{

    public string $path;
    public array $headers = [];
    public LazyCollection $collection;
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getHeaders(): array
    {
        if (empty($this->headers)) {
            $this->loadCollection();
        }

        return $this->headers;
    }

    public function getCollection(): LazyCollection
    {
        return $this->collection ?? $this->loadCollection();
    }

    public function loadCollection($separator = ';'): LazyCollection
    {
        $this->collection = LazyCollection::make(function () use ($separator) {
            $handle = fopen(storage_path('app/' . $this->path), 'r');
            while (($line = fgetcsv($handle, 4096)) !== false) {
                $dataString = implode(", ", $line);
                $row = explode($separator, $dataString);
                yield $row;
            }
            fclose($handle);
        });

        $this->formatHeaders();
        return $this->collection;
    }

    /**
     * replace whitespaces with _ and format str to lower case
     */
    private function formatHeaders(): void
    {
        $this->headers = array_map(function ($header) {
            $header = str_replace(' ', '_', $header);
            return strtolower($header);
        }, $this->collection->first());
    }

    public function writeCsv($collection = [])
    {
        $fileName = now()->format('Y-m-d_H-i-s') . '.csv';
        $path = 'public/' . $fileName;

        Storage::put($path, '');

        $handle = fopen(Storage::path($path), 'w');
        fputcsv($handle, ['code', 'brand', 'price', 'offer_price', 'difference', 'percentage' ]); // Nagłówki kolumn

        foreach ($collection as $key => $row) {
            $data = [
                $row['code'], $row['brand']['name'],
                number_format($row['product_price'], 2),
                number_format($row['temp_product_price'], 2),
                number_format($row['price_difference'], 2),
                number_format($row['price_difference_percentage'], 2),
            ];
            fputcsv($handle, $data);
        }

        fclose($handle);

        return Storage::download($path, $fileName);
    }
}
