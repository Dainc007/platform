<?php

namespace App\Services;

use App\Models\Meeting;
use App\Models\Vacation;
use Carbon\Carbon;


class ReportService
{
    public static function generateMeetingsReport(array $ids): array
    {
        $records = Meeting::with(['user', 'notes'])->whereIn('id', $ids)->get();
        $data = [
            'filename' => 'spotkania.pdf',
            'view' => 'reports.meetings',
            'title' => 'Raport Spotkań',
            'date' => Carbon::now()->format('d-m-Y'),
            'headers' => [
                'user' => 'Pracownik',
                'date' => 'Data',
                'time' => 'Czas',
                'hours_worked' => 'Godziny pracy',
                'status' => 'Status',
                'notes' => 'Notatki'
            ],
            'records' => $records->map(function ($record) {

                return [
                    'user' => $record->user->name,
                    'date' => Carbon::parse($record->start_date)->format('d-m-Y'),
                    'time' => Carbon::parse($record->start_date)->format('H:i') . ' - ' . Carbon::parse($record->end_date)->format('H:i'),
                    'hours_worked' => $record->hours_worked,
                    'status' => __('meeting.status.' . $record->status),
                    'notes' => $record->notes->pluck('content')->join(', ')
                ];
            })
        ];

        return $data;
    }

    public static function generateVacationsReport(array $ids)
    {
        $records = Vacation::with(['user', 'notes'])->whereIn('id', $ids)->get();
        $data = [
            'filename' => 'urlopy.pdf',
            'view' => 'reports.vacations',
            'title' => 'Raport Urlopów',
            'date' => Carbon::now()->format('d-m-Y'),
            'headers' => [
                'user' => 'Pracownik',
                'start_date' => 'Data rozpoczęcia',
                'end_date' => 'Data zakończenia',
                'status' => 'Status',
                'message' => 'Wiadomość'
            ],
            'records' => $records->map(function ($record) {
                return [
                    'user' => $record->user->name,
                    'start_date' => Carbon::parse($record->start_at)->format('d-m-Y'),
                    'end_date' => Carbon::parse($record->end_at)->format('d-m-Y'),
                    'status' => __('vacation.status.' . $record->status),
                    'message' => $record->message
                ];
            })
        ];

        return $data;
    }
}

