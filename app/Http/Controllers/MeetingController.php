<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meeting\StoreMeetingRequest;
use App\Http\Requests\Meeting\UpdateMeetingRequest;
use App\Models\Meeting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $meetings = Meeting::query()
            ->with('user:id,name')
            ->whereDate('start_date', '>=', date('Y-m-d'))
            ->when(!$request->user()->isAdmin(), function (Builder $query) {
                return $query->where('id', '-1');
            })
            ->get([
                'id',
                'title',
                'user_id',
                'description',
                'start_date',
                'end_date',
            ]);

        return inertia('Meeting/Index', [
            'meetings' => $meetings
        ]);
    }

    public function store(StoreMeetingRequest $request): RedirectResponse
    {
        Meeting::create($request->getForInsert());

        return redirect()->back();
    }

    public function update(UpdateMeetingRequest $request, Meeting $meeting)
    {
        //
    }

    public function destroy(Meeting $meeting)
    {
        //
    }
}
