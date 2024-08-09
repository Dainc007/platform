<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\StoreFileRequest;
use App\Http\Requests\File\UpdateFileRequest;
use App\Imports\ProductsImport;
use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\File;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('File/Index', [
            'files' => File::where('path', 'LIKE', '%' . $request->input('search', '') . '%')->paginate(10)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return back()->with(['message' => 'Temporary not supported']);
        return inertia('File/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request)
    {
        $file = $request->file('file');
        $path = $file->storeAs('uploads', $file->getClientOriginalName());
        $contractorId = $request->get('contractor_id');

        $file = File::create([
            'path' => $path,
            'fileable_id' => $request->get('contractor_id'),
            'fileable_type' => Contractor::class
        ]);

        Excel::import(new ProductsImport($contractorId, $request->get('currency_id'), $file->id),$path);

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        if (Storage::exists($file->path)) {
            Storage::delete($file->path);
        }

        $file->delete();

        return back()->with(['message' => 'File Deleted Successfully']);

    }
}
