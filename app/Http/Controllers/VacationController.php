<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vacation\StoreVacationRequest;
use App\Http\Requests\Vacation\UpdateVacationRequest;
use App\Models\User;
use App\Models\Vacation;
use App\Notifications\VacationRequestCreated;
use App\Notifications\VacationStatusChanged;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TableFilterRequest;

class VacationController extends Controller
{

    public function index(TableFilterRequest $request)
    {
        $user = Auth::user();

        if($user->isAdmin()) {
            $vacations = Vacation::with('user:id,name');

            if($request->has('year') && $request->year !== null) {
                $vacations = $vacations->whereYear('start_at', $request->year);
            }

            if($request->has('month') && $request->month !== null) {
                $vacations = $vacations->whereMonth('start_at', $request->month);
            }

            if($request->has('status') && $request->status !== null) {
                $vacations = $vacations->where('status', $request->status);
            }

            $vacations = $vacations->orderBy('start_at', 'asc');
        } else {
            $vacations = $user->vacations()->orderBy('id', 'desc');
        }

        return inertia('Vacation/Index', [
            'vacations' => $vacations->paginate(),
            'upcomingVacations' => Vacation::where('status', 'accepted')->where('start_at', '>=', now())->with('user:id,name')->get(),
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
        $data = $request->validated();

        $start_at_mysql = date('Y-m-d H:i:s', strtotime($data['startDate']));
        $end_at_mysql = date('Y-m-d H:i:s', strtotime($data['endDate']));

        $user = $request->user();

        $vacation = $user->vacations()->create([
            'start_at' => $start_at_mysql,
            'end_at' =>$end_at_mysql,
            'message' => $request->validated('message') ?? $request->validated('note') ?? ''
        ]);

        if ($request->filled('note')) {
            $vacation->notes()->create([
                'content' => $request->validated('note')
            ]);
        }

        User::role('head admin')->firstOrFail()->notify(new VacationRequestCreated($vacation));

        return redirect()->to('dashboard');
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

        $vacation->delete();

        return back()->with(['message' => 'Rekord został usunięty']);
    }
}
