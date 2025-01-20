<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeetingDateRequest;
use App\Http\Requests\UpdateMeetingDateRequest;
use App\Models\MeetingDate;
use App\Services\MeetingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MeetingDateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MeetingService $meetingService): \Inertia\Response|\Inertia\ResponseFactory
    {
        $date = $request->has('date')
            ? Carbon::parse($request->get('date'))->format('Y-m-d')
            : today()->format('Y-m-d');

        return inertia('Meeting/DisableMeetingForm', [
            'meetings' => $meetingService->getAvailableMeetings($date),
            'selectedDate' => $selectedDate = MeetingDate::where('date', $date)->first(),
            'disabledHours' => json_decode($selectedDate?->disabled_hours, true) ?? [],
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
    public function store(StoreMeetingDateRequest $request): void
    {
        $model = MeetingDate::firstOrCreate([
            'date' => $request->validated('date'),
        ]);
        if($request->has('is_enabled')) {
            $model->is_enabled = $request->validated('is_enabled');
        }

        $modelDisabledHours = json_decode($model->disabled_hours, true) ?? [];
        $formDisabledHours = json_decode($request->validated('disabled_hours'), true) ?? [];

        if($request->has('disabled_hours')) {
            $merged = array_unique(array_merge($modelDisabledHours, $formDisabledHours));
            $model->disabled_hours = $merged;
        }

        $model->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(MeetingDate $meetingDate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MeetingDate $meetingDate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeetingDateRequest $request, MeetingDate $meetingDate)
    {
//        return dd($request, $meetingDate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MeetingDate $meetingDate)
    {
        //
    }
}
