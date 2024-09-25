<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;


class BrandController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Brand/Index', [
            'brands' => Brand::where('name', 'LIKE', '%' . $request->input('search', '') . '%')
                ->orderBy('name', 'asc')
                ->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Brand/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        Brand::updateOrCreate($request->validated(), $request->validated());

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

//        return inertia('Brand/Edit', ['brand' => $brand]);
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
