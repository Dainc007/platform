<?php

namespace Database\Seeders;

use App\Models\Carrier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Carrier::count() === 0) {
            Carrier::insert([
                ['name' => 'Przewoźnik 1'],
                ['name' => 'Przewoźnik 2'],
            ]);
        }
    }
}
