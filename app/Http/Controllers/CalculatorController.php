<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalculatorRequest;
use App\Http\Requests\UpdateCalculatorRequest;
use App\Models\Calculator;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\DB;

class CalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $products = (DB::connection('second_db')
            ->table('products')
            ->where('categories_id', '=', 4)
            ->where(function($query) {
                $query->where('title', 'like', '%Sofar Solar%');
//                    ->orWhere('title', 'like', '%Hypontech%');
            })
            ->get());
        return inertia('Calculator/Index', [
            'installationTypes' => Calculator::INSTALLATION_TYPES,
            'panels'  => Calculator::PANELS,
            'montageSystemTypes' => Calculator::MONTAGE_SYSTEM_TYPES,
            'products' => $products,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCalculatorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Calculator $calculator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Calculator $calculator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCalculatorRequest $request, Calculator $calculator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calculator $calculator)
    {
        //
    }
}
