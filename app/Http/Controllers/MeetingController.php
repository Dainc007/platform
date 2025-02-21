<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meeting\StoreMeetingRequest;
use App\Http\Requests\Meeting\UpdateMeetingRequest;
use App\Models\Meeting;
use App\Models\MeetingDate;
use App\Models\User;
use App\Notifications\MeetingCreated;
use App\Notifications\MeetingStatusChanged;
use App\Services\MeetingService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MeetingController extends Controller
{
    public function index(Request $request, MeetingService $meetingService)
    {
        $date = $request->has('date')
            ? Carbon::parse($request->get('date'))->format('Y-m-d')
            : today()->format('Y-m-d');

        return Inertia::render('Meeting/Index', [
            'meetings' => fn () => ($meetingService->getAvailableMeetings($date)),
            'upcomingMeetings' => Meeting::with(['notes' ,'user'])->orderBy('start_date')->paginate(10),
            'disabledDates' => MeetingDate::where('date', '>=', today()->format('Y-m-d'))->where('is_enabled', false)->pluck('date')->toArray() ?? [],
        ]);
    }

    public function store(StoreMeetingRequest $request): RedirectResponse
    {
        $meeting = Meeting::create($request->getForInsert());

        if ($request->filled('note')) {
            $meeting->notes()->create([
                'content' => $request->validated('note')
            ]);
        }

        User::role('head admin')->firstOrFail()->notify(new MeetingCreated($meeting));

        return redirect()->to('dashboard');
    }

    public function update(UpdateMeetingRequest $request, Meeting $meeting)
    {
        $meeting->update($request->validated());

        $meeting->user->notify(new MeetingStatusChanged($meeting));
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();

        return back()->with(['message' => 'Rekord został usunięty']);
    }
}
