<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;


class BrandController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Brand/Index', [
            'columns' => [
                'brands.name',
            ],
            'brands' => Brand::where('name', 'LIKE', '%' . $request->input('search', '') . '%')->paginate(10)->through(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                ];
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Brand/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $data = $request->validated();
        Brand::updateOrCreate($data, $data);

        return redirect()->back()->with(['message' => 'Marka została dodana poprawnie.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Brand $brand)
    {
        return redirect()->back()->with(['message' => 'Not Supported (sorry!).']);

        return Inertia::render('Brand/Edit', [
                'brand' => $brand
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand has been deleted!');
    }
}
