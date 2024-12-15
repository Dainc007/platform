<?php

namespace App\Http\Controllers;

use App\Actions\Contractor\CreateContractor;
use App\Actions\File\CreateFile;
use App\Http\Requests\Analytics\CompareOffersRequest;
use App\Jobs\PrepareProductComparison;
use App\Jobs\ProcessImportJob;
use App\Models\Brand;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('brand_id')) {
            $files = File::whereHas('products', function ($query) use ($request) {
                $query->where('brand_id', $request->get('brand_id'));
            })->get();
        }

        return Inertia::render('Analytics/Index', [
            'brands' => fn () => Brand::orderBy('name', 'asc')->get(),
            'files' => fn () => $files ?? []
        ]);
    }

    public function create()
    {
        return Inertia::render('Analytics/Import', [
            'brands' => Brand::orderBy('name', 'asc')->get(),
        ]);
    }

    public function store(CompareOffersRequest $request)
    {
        try {
            $contractor = CreateContractor::handle('Analytics');
            $file = CreateFile::handle(($request->file('file')), $contractor);
            $data = $request->validated() + [
                    'path' => $file->path,
                    'file_id' => $file->id,
                    'contractor_id' => $contractor->id,
                ];
            unset($data['file']);
            DB::table('temporary_products')->truncate();
            ProcessImportJob::dispatch($data)->onQueue('analytics');
            PrepareProductComparison::dispatch(['files' => $data['files'], 'brand_id' => $data['brand_id']])->onQueue('analytics');
        } catch (\Exception $e) {
            Log::error('Error processing records: ' . $e->getMessage());
        }

        return to_route('analytics.index')->with(['message' => 'Twój plik jest w trakcie przygotowywania.']);
    }
}
