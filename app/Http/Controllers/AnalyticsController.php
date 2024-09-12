<?php

namespace App\Http\Controllers;

use App\Exports\FileExport;
use App\Http\Requests\Analytics\CompareOffersRequest;
use App\Models\Brand;
use App\Models\File;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FileImport;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Analytics/Index', [
            'brands' => Brand::orderBy('name', 'asc')->get(),
            'files' => Inertia::lazy(fn() => File::whereHas('products', function ($query) use ($request) {
                $query->where('brand_id', $request->get('brand_id'));
            })->get())
        ]);
    }

    public function store(CompareOffersRequest $request)
    {
        $brandId = $request->get('brand_id');
        $files = $request->get('files');
        $file = $request->file('file');

        $products = Product::where('brand_id', $brandId)
            ->whereIn('file_id', $files)
            ->get();
        $import = new FileImport;

        Excel::import($import, $file);

        $data = $import->data;

        $diff = $products->diffAssoc($data);
        dd($diff);
//        $fileExcel =  (new FileExport($diff))->download('compare_offers.csv');
//        $path = ($fileExcel->getFile()->getPath());
//        return Excel::download(new FileExport($diff), 'testing.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
