<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Metal24Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CarrierSeeder::class,
            CarTypeSeeder::class,
            SupplierSeeder::class,
        ]);
    }
}
