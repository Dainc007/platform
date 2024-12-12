<?php

namespace App\Http\Controllers;

use App\Actions\Contractor\CreateContractor;
use App\Actions\File\CreateFile;
use App\Http\Requests\Analytics\CompareOffersRequest;
use App\Jobs\CreateAnalyticsFile;
use App\Jobs\PrepareProductsToComparsionJob;
use App\Jobs\ProcessImportJob;
use App\Jobs\ProcessTemporaryProductImportJob;
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
        return $this->export();
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
            PrepareProductsToComparsionJob::dispatch(['files' => $data['files'], 'brand_id' => $data['brand_id']])->onQueue('analytics');
            ProcessImportJob::dispatch($data)->onQueue('analytics');
            $this->export();
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
        $results = $this->getResults()->toArray();
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
        return TemporaryProduct::from('temporary_products as tp1')
            ->join('temporary_products as tp2', function ($join) {
                $join->on('tp1.code', '=', 'tp2.code')
                    ->on('tp1.brand_id', '=', 'tp2.brand_id')
                    ->where('tp1.contractor_id', '=', 42)
                    ->where('tp2.contractor_id', '<>', 42)
                    ->whereNotNull('tp1.contractor_id')
                    ->whereNotNull('tp2.contractor_id');
            })
            ->select(
                'tp1.code',
                'tp1.brand_id',
                'tp1.contractor_id as contractor_id_1',
                'tp1.price as price_1',
                'tp2.contractor_id as contractor_id_2',
                'tp2.price as price_2',
                DB::raw('ABS(tp1.price - tp2.price) as price_difference'),
                DB::raw('((tp1.price - tp2.price) / tp1.price) * 100 as price_difference_percentage')
            )
            ->orderBy('tp1.code')
            ->orderBy('tp1.brand_id')
            ->orderBy('tp1.contractor_id')
            ->get();
    }

}
