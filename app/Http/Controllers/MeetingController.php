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
use App\Http\Requests\TableFilterRequest;
class MeetingController extends Controller
{
    public function index(TableFilterRequest $request, MeetingService $meetingService)
    {
        $date = $request->has('date')
            ? Carbon::parse($request->get('date'))->format('Y-m-d')
            : today()->format('Y-m-d');

        $upcomingMeetings = Meeting::with(['notes' ,'user']);

        if($request->has('year') && $request->year !== null) {
            $upcomingMeetings = $upcomingMeetings->whereYear('start_date', $request->year);
        }

        if($request->has('month') && $request->month !== null) {
            $upcomingMeetings = $upcomingMeetings->whereMonth('start_date', $request->month);
        }

        if($request->has('status') && $request->status !== null) {
            $upcomingMeetings = $upcomingMeetings->where('status', $request->status);
        }

        // Add sorting
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');
        $upcomingMeetings = $upcomingMeetings->orderBy($sort, $direction);

        return Inertia::render('Meeting/Index', [
            'meetings' => fn () => ($meetingService->getAvailableMeetings($date)),
            'upcomingMeetings' => $upcomingMeetings->paginate(10)->withQueryString(),
            'disabledDates' => MeetingDate::where('date', '>=', today()->format('Y-m-d'))->where('is_enabled', false)->pluck('date')->toArray() ?? [],
            'hasAccessToAdminNotes' => $request->user()?->hasAccessToAdminNotes()
        ]);
    }

    public function store(StoreMeetingRequest $request): RedirectResponse
    {
        $meetingData = $request->getForInsert();

        $isAlreadyBooked = Meeting::where([
            'start_date' => $meetingData['start_date'],
            'end_date' => $meetingData['end_date'],
            'status' => $meetingData['status'],
        ])->exists();

        if($isAlreadyBooked) {
            return redirect()->to(route('meeting.index'))->with([
                'message' => 'Termin został zajęty przez innego użytkownika i nie jest już dostępny'
            ]);
        }

        $meeting = Meeting::create($meetingData);

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
        if($meeting->isDirty('status')) {
            $meeting->user->notify(new MeetingStatusChanged($meeting));
        }

        return back()->with(['message' => 'Rekord został zaktualizowany']);

    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();

        return back()->with(['message' => 'Rekord został usunięty']);
    }
}
