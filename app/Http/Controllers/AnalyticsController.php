<?php

namespace App\Http\Controllers;

use App\Actions\Contractor\CreateContractor;
use App\Actions\File\CreateFile;
use App\Http\Requests\Analytics\CompareOffersRequest;
use App\Jobs\CreateAnalyticsFile;
use App\Jobs\ProcessImportJob;
use App\Models\Brand;
use App\Models\Contractor;
use App\Models\File;
use App\Models\Product;
use App\Models\TemporaryProduct;
use App\Services\FileService;
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
            ProcessImportJob::dispatch($data)->onQueue('analytics');
        } catch (\Exception $e) {
            Log::error('Error processing records: ' . $e->getMessage());
        }

        return to_route('analytics.index')->with(['message' => 'Twój plik jest w trakcie przygotowywania.']);
    }

    public function truncate()
    {
        DB::table('temporary_products')->truncate();
        return back()->with(['message' => 'Tabela została wyczyszczona']);
    }

    public function export()
    {
        $results = $this->getResults()->get()->toArray();
        $message = 'Nie wybrano plików ani marki';
        if(!empty($results)) {
            CreateAnalyticsFile::dispatch($results)->onQueue('analytics');
            $message = 'Pllik w trakcie przygotowywania';
        }

        return back()->with('message', $message);
    }

    //todo fix this!
    public function show()
    {
        return $this->export();
    }

    private function getResults()
    {
        $files = [25, 26];
        return TemporaryProduct::whereIn('products.file_id', $files)
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
            );
    }

}
