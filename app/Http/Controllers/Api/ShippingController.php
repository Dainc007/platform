<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculateShippingRequest;
use App\Services\ShippingCalculator;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CalculateShippingRequest $request, ShippingCalculator $calculator): int
    {
        return $calculator->calculateShippingCost($request->validated());
    }
}
