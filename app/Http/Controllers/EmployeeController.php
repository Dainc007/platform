<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Employee/Index', [
                'columns' => [
                    'employees.name',
//                    'employees.email',
                    'employees.status',
                    'employees.phone_number',
                ],
                'employees' => Employee::whereAny(['firstname', 'lastname', 'phone_number', 'email'], 'LIKE', '%' . $request->input('search', '') . '%')->paginate(10)
                    ->through(function ($item) {
                        return [
                            'id' => $item->id,
                            'user_id' => $item->user_id,
                            'email' => $item->email,
                            'firstname' => $item->firstname,
                            'lastname' => $item->lastname,
                            'phone_number' => $item->phone_number,
                            'name' => $item->firstname . ' ' . $item->lastname,
                        ];
                    }),
            ]
        );
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
    public function store(StoreEmployeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return back()->with(['message' => 'Feature Not Supported']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $model)
    {
        $model->delete();

        return back()->with(['message' => 'Deleted']);
    }
}
