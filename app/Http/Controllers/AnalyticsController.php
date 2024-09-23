<?php

namespace App\Http\Controllers;

use App\Http\Requests\Analytics\CompareOffersRequest;
use App\Jobs\ProcessImportJob;
use App\Models\Brand;
use App\Models\Contractor;
use App\Models\File;
use App\Models\Product;
use App\Models\TemporaryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $products = TemporaryProduct::paginate(10);

        return Inertia::render('Analytics/Index', [
            'products' => $products,
            'brands' => Brand::orderBy('name', 'asc')->get(),
            'files' => Inertia::lazy(fn() => File::whereHas('products', function ($query) use ($request) {
                $query->where('brand_id', $request->get('brand_id'));
            })->get())
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Analytics/Import');
    }

    public function store(CompareOffersRequest $request)
    {
        $file = $request->file('file');
        $path = $file->storeAs('uploads', $file->getClientOriginalName());

        (Contractor::firstOrCreate(['name' => 'Test Contractor']))->files()->create(['path' => $path]);

        ProcessImportJob::dispatch($path);

        return to_route('analytics.index')->with(['message' => 'Twój plik jest w trakcie przygotowywania.']);
    }
}
