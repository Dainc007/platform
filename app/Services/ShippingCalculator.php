<?php

namespace App\Services;

class ShippingCalculator
{
    /**
     * Create a new class instance.
     */

    public function __construct()
    {
        //załaduj jakieś wartości;
    }

    public function calculateShippingCost($data): int
    {
        return rand(1,1000);
    }
}
