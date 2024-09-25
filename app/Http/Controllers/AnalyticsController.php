<?php

namespace App\Http\Controllers;

use App\Http\Requests\Analytics\CompareOffersRequest;
use App\Jobs\ProcessImportJob;
use App\Models\Brand;
use App\Models\Contractor;
use App\Models\File;
use App\Models\Product;
use App\Models\TemporaryProduct;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $results = $this->getResults($request)->paginate();

        return Inertia::render('Analytics/Index', [
            'products' => Inertia::lazy(fn() => $results ?? TemporaryProduct::with(['brand:id,name'])->paginate()),
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

        defer(function () use ($path) {
            ProcessImportJob::dispatch($path)->onQueue('import');
        });

        return to_route('analytics.index')->with(['message' => 'Twój plik jest w trakcie przygotowywania.']);
    }

    public function truncate()
    {
        DB::table('temporary_products')->truncate();
        return back()->with(['message' => 'Tabela została wyczyszczona']);
    }

    public function export(Request $request)
    {
        $results = $this->getResults($request)->get()->toArray();
        $service = new FileService('');
        return $service->writeCsv($results);
    }

    //todo fix this!
    public function show()
    {
        return $this->export();
    }

    private function getResults(Request $request)
    {
        $files = $request->get('files') ?? [];
        $search = $request->input('search', '');

        return Product::where('products.code', 'LIKE', $search . '%')
            ->whereIn('file_id', $files)
            ->leftJoin('temporary_products', function ($join) {
                $join->on('products.code', '=', 'temporary_products.code')
                    ->on('products.brand_id', '=', 'temporary_products.brand_id');
            })
            ->select(
                'products.code',
                'products.brand_id',
                'products.price as product_price',
                'temporary_products.price as temp_product_price',
                DB::raw('(products.price - temporary_products.price)  as price_difference'),
                DB::raw('((products.price - temporary_products.price) / products.price) * 100 as price_difference_percentage')
            )
            ->whereNotNull('temporary_products.id')
            ->with('brand:id,name');
    }

}
