<?php

namespace App\Services;

use App\Models\Meeting;
use App\Models\MeetingDate;
use Carbon\Carbon;

class MeetingService
{
    public static function getAvailableMeetings($date): array
    {
        $firstAvailableMeetingHour = Carbon::createFromTime(Meeting::STARTING_HOUR, 0);
        $lastAvailableMeetingHour = Carbon::createFromTime(Meeting::FINISHING_HOUR, 0);

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

        $disabledHours = json_decode(MeetingDate::where('date', $date)->value('disabled_hours') ?? '[]', true);

        while ($firstAvailableMeetingHour->lt($lastAvailableMeetingHour)) {
            $from = $firstAvailableMeetingHour->format('H:i');
            $to   = $firstAvailableMeetingHour->copy()->addMinutes(Meeting::DURATION)->format('H:i');
            if(!in_array($from, $disabledHours)) {
                $availableMeetings[$from] = $to;
            }
            $firstAvailableMeetingHour->addMinutes(Meeting::DURATION);
        }

        return array_diff($availableMeetings, $bookedMeetings);
    }
}
