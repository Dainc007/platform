<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vacation\StoreVacationRequest;
use App\Http\Requests\Vacation\UpdateVacationRequest;
use App\Models\User;
use App\Models\Vacation;
use App\Notifications\VacationStatusChanged;
use Illuminate\Support\Facades\Auth;

class VacationController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $vacations = $user->isAdmin()
            ? Vacation::where('status', 'pending')->get()
            : $user->vacations;

        return inertia('Vacation/Index', [
            'vacations' => $vacations,
            'statuses' => Vacation::AVAILABLE_STATUSES
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
    public function store(StoreVacationRequest $request)
    {
        $date = $request->validated('date');
        $request->user()->vacations()->create([
            'start_at' => $date[0],
            'end_at' => $date[1] ?? $date[0],
        ]);

        return redirect()->back()->with('message', 'Vacation created.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Vacation $vacation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vacation $vacation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVacationRequest $request, Vacation $vacation)
    {
        $vacation->update($request->validated());

        if($request->has('message')) {
            $vacation->user()->notify(new VacationStatusChanged());
        }

        return redirect()->back()->with('message', 'Vacation updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vacation $vacation)
    {
        //
    }
}
