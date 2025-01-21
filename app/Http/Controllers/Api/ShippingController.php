<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculateShippingRequest;
use App\Models\Supplier;
use App\Services\ShippingCalculator;
use \Programic\DistanceMatrix\DistanceMatrix;

class ShippingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CalculateShippingRequest $request, ShippingCalculator $calculator, DistanceMatrix $distanceMatrix): int
    {
        $data = [
            'totalProductsWeight' => 0
        ];
        $address = $request->get('address');
        $data['city'] = $address['city'];
        $data['postcode'] = $address['postcode'];
        $data['street'] = $address['address1'];
        $data['fullAddress'] = $data['street'] . ', ' . $data['postcode'] . ' ' . $data['city'];

        foreach ($request->get('products') as $product) {
            $data['supplier_id'] = $product['id_supplier'];
            $data['totalProductsWeight'] += $product['weight'] * $product['cart_quantity'];
        }

        $supplier = Supplier::find($data['supplier_id']);

        dd($supplier->addresses->toArray());

        $response = $distanceMatrix->from($data['fullAddress'])->to($data['totalProductsWeight']);
    }
}
