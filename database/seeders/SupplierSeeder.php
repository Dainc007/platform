<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSuppliers = [
            [
                'supplier' => [
                    'name' => 'Huta Aluminium Konin',
                    'min_payload' => 23000,
                ],
                'address' => [
                    'city' => 'Konin',
                    'post_code' => '65-510',
                    'street' => 'Hutnicza 1',
                    'country' => 'pl',
                ],
                'contact' => [
                    'type' => 'phone',
                    'value' => '555 555 555'
                ]
            ],

            [
                'supplier' => [
                    'name' => 'ArcelorMittal Poland, oddział w Dąbrowie Górniczej',
                    'min_payload' => 23000,
                ],
                'address' => [
                    'city' => 'Dąbrowa Górnicza',
                    'post_code' => '41-303',
                    'street' => 'Aleja Józefa Piłsudskiego 92',
                    'country' => 'pl',
                ],
                'contact' => [
                    'type' => 'phone',
                    'value' => '111 222 333',
                ]
            ],
        ];

        if (Supplier::count() === 0) {
            foreach ($defaultSuppliers as $defaultSupplier) {
                $supplier = Supplier::factory()->create($defaultSupplier['supplier']);
                $supplier->addresses()->create($defaultSupplier['address']);
                $supplier->contacts()->create($defaultSupplier['contact']);
            }
        }
    }
}
