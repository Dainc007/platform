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
}
