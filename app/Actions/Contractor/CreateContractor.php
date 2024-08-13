<?php

namespace App\Actions\Contractor;


use App\Models\Contractor;

class CreateContractor
{

    public static function handle(string $name) : Contractor
    {
        return Contractor::updateOrCreate(['name' => $name], ['name' => $name]);
    }

}
