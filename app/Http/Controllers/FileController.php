<?php

namespace App\Http\Controllers;

use App\Actions\File\CreateFile;
use App\Actions\Product\CreateProduct;
use App\Actions\Product\MassCreateProduct;
use App\Http\Requests\File\StoreFileRequest;
use App\Http\Requests\File\UpdateFileRequest;
use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\File;

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
        $file = CreateFile::handle($request->file('file'), Contractor::findOrFail($request['contractor_id']));
        $data = $request->validated();
        $data['path'] = $file->path;
        $data['file_id'] = $file->id;
        unset($data['file']);
        MassCreateProduct::fromCsvFile($data);

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
