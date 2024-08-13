<?php

namespace App\Actions\File;

use App\Inerfaces\Fileable;
use App\Models\File;


class CreateFile
{
    public static function handle($file, Fileable $model) : File
    {
        return $model->files()->create([
            'path' => $file->storeAs('uploads', $file->getClientOriginalName())
        ]);
    }
}
