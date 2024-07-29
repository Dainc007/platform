<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contractor\StoreContractorRequest;
use App\Http\Requests\Contractor\UpdateContractorRequest;
use App\Imports\ProductsImport;
use App\Models\Contractor;
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
            'contractors' => Contractor::where('name', 'LIKE', '%' . $request->input('search', '') . '%')->paginate(10)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Contractor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractorRequest $request)
    {
        $file = $request->file('file');
        $path = $file->storeAs('uploads', $file->getClientOriginalName());

        $contractor = Contractor::create([
            'name' => $request->get('name')
        ]);

        $contractor->files()->create(['path' => $path]);

        Excel::import(new ProductsImport($contractor->id, 4),$path);

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractorRequest $request, Contractor $contractor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contractor $contractor)
    {
        //
    }
}
