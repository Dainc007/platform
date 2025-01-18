<?php

namespace Database\Seeders;

use App\Models\Carrier;
use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Carrier::count() > 0) return;

        $plnCurrency = Currency::where('code', 'PLN')->first()->id;
        $euroCurrency = Currency::where('code', 'EUR')->first()->id;

        $data = [
            [
                'distance_limit' => 50,
                'price_without_tax' => 500,
                'tax_rate' => 23,
                'currency_id' => $plnCurrency
            ],
            [
                'distance_limit' => 50,
                'price_without_tax' => 150,
                'tax_rate' => 23,
                'currency_id' => $euroCurrency
            ],
            [
                'distance_limit' => 150,
                'price_without_tax' => 500,
                'tax_rate' => 23,
                'currency_id' => $plnCurrency
            ],
            [
                'distance_limit' => 150,
                'price_without_tax' => 150,
                'tax_rate' => 23,
                'currency_id' => $euroCurrency
            ],
            [
                'distance_limit' => 250,
                'price_without_tax' => 500,
                'tax_rate' => 23,
                'currency_id' => $plnCurrency
            ],
            [
                'distance_limit' => 250,
                'price_without_tax' => 150,
                'tax_rate' => 23,
                'currency_id' => $euroCurrency
            ],
            [
                'distance_limit' => 350,
                'price_without_tax' => 500,
                'tax_rate' => 23,
                'currency_id' => $plnCurrency
            ],
            [
                'distance_limit' => 350,
                'price_without_tax' => 150,
                'tax_rate' => 23,
                'currency_id' => $euroCurrency
            ],
        ];
        $carrier = Carrier::create(['name' => 'Przewoźnik 1']);
        foreach ($data as $pricingData) {
            $pricingData['price_with_tax'] = $pricingData['price_without_tax'] * (1 + $pricingData['tax_rate'] / 100);
            $pricingData['tax'] = $pricingData['price_without_tax'] * ($pricingData['tax_rate'] / 100);

            $carrier->pricings()->create($pricingData);
        }

        $carrier2 = Carrier::create(['name' => 'Przewoźnik 2']);

        $data2 = [
            [
                'distance_limit' => 0,
                'price_without_tax' => 6,
                'tax_rate' => 23,
                'currency_id' =>$plnCurrency
            ],
            [
                'distance_limit' => 0,
                'price_without_tax' => 2.50,
                'tax_rate' => 23,
                'currency_id' => $euroCurrency
            ],
        ];

        foreach ($data2 as $pricingData) {
            $pricingData['price_with_tax'] = $pricingData['price_without_tax'] * (1 + $pricingData['tax_rate'] / 100);
            $pricingData['tax'] = $pricingData['price_without_tax'] * ($pricingData['tax_rate'] / 100);

            $carrier2->pricings()->create($pricingData);
        }
    }
}
