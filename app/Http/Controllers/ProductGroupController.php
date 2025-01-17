<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductGroupRequest;
use App\Http\Requests\UpdateProductGroupRequest;
use App\Models\Group;
use App\Models\ProductGroup;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Inertia::render('ProductGroup/Index', Group::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Inertia::render('ProductGroup/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductGroupRequest $request)
    {
        Group::create($request->validated());

        return Redirect::route('product-group.index')->with('success', 'Product Group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductGroup $productGroup)
    {
        return Inertia::render('ProductGroup/Show', ['productGroup' => $productGroup]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductGroup $productGroup)
    {
        return Inertia::render('ProductGroup/Edit', ['productGroup' => $productGroup]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductGroupRequest $request, ProductGroup $productGroup)
    {
        $productGroup->update($request->validated());

        return Redirect::route('product-group.index')->with('success', 'Product Group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGroup $productGroup)
    {
        $productGroup->delete();

        return Redirect::route('product-group.index')->with('success', 'Product Group deleted successfully.');
    }
}
