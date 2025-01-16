<?php

namespace Database\Seeders;

use App\Models\CarType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carTypes = [
            [
                'name' => 'BUS 8 EPAL',
                'length' => 3200,
                'width' => 2200,
                'height' => 2200,
                'max_payload' => 3500
            ],
            [
                'name' => 'BUS 10 EPAL',
                'length' => 4200,
                'width' => 2200,
                'height' => 2200,
                'max_payload' => 3500
            ],
            [
                'name' => 'BUS 12 EPAL',
                'length' => 4800,
                'width' => 2200,
                'height' => 2200,
                'max_payload' => 3500
            ],
            [
                'name' => 'TIR do 7 tony',
                'length' => 6000,
                'width' => 2450,
                'height' => 2400,
                'max_payload' => 7500
            ],
            [
                'name' => 'TIR Firanka',
                'length' => 13600,
                'width' => 2450,
                'height' => 3000,
                'max_payload' => 24000,
            ],
            [
                'name' => 'TIR z naczepą burtową',
                'length' => 13600,
                'width' => 3000,
                'height' => 3000,
                'max_payload' => 24000,
            ],
            [
                'name' => 'TIR z naczepą do 3,2 M',
                'length' => 13600,
                'width' => 3200,
                'height' => 3000,
                'max_payload' => 24000
            ],
            [
                'name' => 'TIR z naczepą na KOILE',
                'length' => 13600,
                'width' => 2450,
                'height' => 3000,
                'max_payload' => 24000
            ]
        ];

        if (CarType::count() === 0) {
            foreach ($carTypes as $carType) {
                CarType::factory()->create($carType);
            }
        }
    }
}
