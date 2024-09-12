<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FileImport implements ToCollection
{
    public $data;

    public function collection(Collection $rows)
    {
        $this->data = $rows;
    }
}
