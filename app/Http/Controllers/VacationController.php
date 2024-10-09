<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vacation\StoreVacationRequest;
use App\Http\Requests\Vacation\UpdateVacationRequest;
use App\Models\User;
use App\Models\Vacation;
use App\Notifications\MeetingCreated;
use App\Notifications\VacationRequestCreated;
use App\Notifications\VacationStatusChanged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class VacationController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $vacations = $user->isAdmin()
            ? Vacation::where('status', 'pending')->with('user:id,name')->get()
            : $user->vacations()->orderBy('id', 'desc')->get();

        return inertia('Vacation/Index', [
            'vacations' => $vacations,
            'upcomingVacations' => Vacation::where('status', 'accepted')->where('start_at', '>=', now())->with('user:id,name')->get(),
            'statuses' => array_diff(Vacation::AVAILABLE_STATUSES, ['cancelled'])
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
        $end_at = $date[1] ?? $date[0];
        $start_at_mysql = date('Y-m-d H:i:s', strtotime($date[0]));
        $end_at_mysql = date('Y-m-d H:i:s', strtotime($end_at));

        $user = $request->user();

        $vacation = $user->vacations()->create([
            'start_at' => $start_at_mysql,
            'end_at' =>$end_at_mysql,
            'message' => $request->validated('message') ?? '',
        ]);

        User::role('head admin')->firstOrFail()->notify(new VacationRequestCreated($vacation));


        return redirect()->back();

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
    public function update(UpdateVacationRequest $request, Vacation $vacation): \Illuminate\Http\RedirectResponse
    {
        $vacation->update($request->validated());

        $vacation->user->notify(new VacationStatusChanged($vacation));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vacation $vacation)
    {
        //
    }
}
