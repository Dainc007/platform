<?php

namespace App\Services;

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
        $path = storage_path('app/' . $this->path);
        $handle = fopen($path, 'r');

        $this->collection = LazyCollection::make(function () use ($separator, $handle) {
            while (($line = fgetcsv($handle, 4096)) !== false) {
                $rowAsString = implode(", ", $line);
                $rowAsArray = explode($separator, $rowAsString);
                yield $rowAsArray;
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
            $header = strtolower($header);
            $header = in_array($header, ['sku', 'reference number']) ? 'code' : $header;
            return str_contains($header, 'price') ? 'price' : $header;
        }, $this->collection->first());
    }
}
