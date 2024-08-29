<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Imports\ProductsImport;
use App\Models\Contractor;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $products = Product::where(function ($query) use ($search) {
            $query->where('products.code', 'LIKE', $search . '%')
                ->orWhere('products.type', 'LIKE', $search . '%');
        })
            ->join(DB::raw('(SELECT code, AVG(price) as avg_price FROM products GROUP BY code) as avg_prices'), function ($join) {
                $join->on('products.code', '=', 'avg_prices.code');
            })
            ->select('products.*', 'avg_prices.avg_price', DB::raw('((products.price - avg_prices.avg_price) / avg_prices.avg_price) * 100 as price_difference_percentage'))
            ->with(['currency', 'contractor', 'brand'])
            ->orderBy('products.price')
            ->paginate(15);

        return inertia('Product/Index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
