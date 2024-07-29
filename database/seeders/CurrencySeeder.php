<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Currency::factory(10)->create();

        foreach (Currency::AVAILABLE_CURRENCIES as $name => $code) {
            Currency::updateOrCreate(['code' => $code], ['name' => $name, 'code' => $code]);
        }
    }
}
