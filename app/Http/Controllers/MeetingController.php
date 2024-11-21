<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meeting\StoreMeetingRequest;
use App\Http\Requests\Meeting\UpdateMeetingRequest;
use App\Models\Meeting;
use App\Models\User;
use App\Notifications\MeetingCreated;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
    {

        return inertia('Meeting/Index', [
            'meetings' => $this->getAvailableMeetings($request),
//            'upcomingMeetings' => Meeting::where('start_date', '>=', now()->format('Y-m-d h:i'))->with(['notes' ,'user'])->orderBy('start_date')->paginate(10)
            'upcomingMeetings' => Meeting::with(['notes' ,'user'])->orderBy('start_date', 'desc')->paginate(10)
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
    }

    public function destroy(Meeting $meeting)
    {
        //
    }

    private function getAvailableMeetings(Request $request): array
    {
        $firstAvailableMeetingHour = Carbon::createFromTime(Meeting::STARTING_HOUR, 0);
        $lastAvailableMeetingHour = Carbon::createFromTime(Meeting::FINISHING_HOUR, 0);

        $date = $request->has('date')
            ? Carbon::parse($request->get('date'))->format('Y-m-d')
            : today()->format('Y-m-d');

        $availableMeetings = [];

        $bookedMeetings = Meeting::where('start_date', 'LIKE', '%' . $date . '%')
            ->where('status', 'booked')
            ->pluck('start_date')
            ->mapWithKeys(function ($date) {
                $start = Carbon::parse($date)->format('H:i');
                $end = Carbon::parse($date)->addMinutes(20)->format('H:i');
                return [$start => $end];
            })
            ->toArray();

        while ($firstAvailableMeetingHour->lt($lastAvailableMeetingHour)) {
            $from = $firstAvailableMeetingHour->format('H:i');
            $to   = $firstAvailableMeetingHour->copy()->addMinutes(Meeting::DURATION)->format('H:i');
            $availableMeetings[$from] = $to;
            $firstAvailableMeetingHour->addMinutes(Meeting::DURATION);
        }

        return array_diff($availableMeetings, $bookedMeetings);
    }
}
