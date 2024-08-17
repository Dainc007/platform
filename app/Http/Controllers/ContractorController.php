<?php

namespace App\Http\Controllers;

use App\Actions\Contractor\CreateContractor;
use App\Actions\File\CreateFile;
use App\Actions\Product\CreateProduct;
use App\Http\Requests\Contractor\StoreContractorRequest;
use App\Http\Requests\Contractor\UpdateContractorRequest;
use App\Models\Brand;
use App\Models\Contractor;
use Illuminate\Http\Request;


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
        return inertia('Contractor/Create', [
            'brands' => Brand::orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractorRequest $request)
    {
        $contractor = CreateContractor::handle($request->validated('name'));

        if($request->hasFile('file')) {
            $file = CreateFile::handle($request->validated('file'), $contractor);
            CreateProduct::fromExcelFile($request->validated() + ['contractor_id' => $contractor->id], $file);
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
            'brands' => Brand::orderBy('name', 'asc')->get()
            ]
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
