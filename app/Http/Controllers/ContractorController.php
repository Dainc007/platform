<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contractor\StoreContractorRequest;
use App\Http\Requests\Contractor\UpdateContractorRequest;
use App\Imports\ProductsImport;
use App\Models\Brand;
use App\Models\Contractor;
use App\Models\Currency;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ContractorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('Contractor/Index', [
            'contractors' => Contractor::where('name', 'LIKE', '%' . $request->input('search', '') . '%')->with('files')->paginate(10)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Contractor/Create', ['brands' => Brand::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractorRequest $request)
    {
        $name = $request->get('name');
        $contractor = Contractor::updateOrCreate(['name' => $name], ['name' => $name]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->storeAs('uploads', $file->getClientOriginalName());
            $currencyId = $request->get('currency_id');
            $brandId = $request->get('brand_id');

            $file = $contractor->files()->create(['path' => $path]);

            Excel::import(new ProductsImport($contractor->id, $currencyId, $file->id, $brandId), $path);
        }

        return redirect()->route('contractors.index')->with('success', 'Contractor added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contractor $contractor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contractor $contractor)
    {
        return inertia('Contractor/Edit', [
            'contractor' => $contractor->load('files'),
            'brands' => Brand::all()]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractorRequest $request, Contractor $contractor)
    {
        $contractor->update($request->validated());

        return back()->with(['success' => 'Contractor updated successfully!', 'contractor' => $contractor]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contractor $contractor)
    {
        $contractor->delete();

        return back()->with(['message' => 'Contractor Deleted Successfully']);
    }
}
