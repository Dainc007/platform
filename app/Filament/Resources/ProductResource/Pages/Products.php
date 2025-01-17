<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class Products extends ManageRecords
{
    protected static string $resource = ProductResource::class;
}
