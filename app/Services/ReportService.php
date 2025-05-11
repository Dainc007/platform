<?php

namespace App\Services;

use App\Models\Meeting;
use App\Models\Vacation;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportService
{
    public static function generateMeetingsReport(array $ids)
    {
        $records = Meeting::with(['user', 'notes'])->whereIn('id', $ids)->get();
        $data = [
            'title' => 'Raport Spotkań',
            'date' => Carbon::now()->format('d-m-Y'),
            'records' => $records->map(function ($record) {
                return [
                    'user' => $record->user->name,
                    'date' => Carbon::parse($record->start_date)->format('d-m-Y'),
                    'time' => Carbon::parse($record->start_date)->format('H:i') . ' - ' . Carbon::parse($record->end_date)->format('H:i'),
                    'hours_worked' => $record->hours_worked,
                    'status' => $record->status,
                    'notes' => $record->notes->pluck('content')->join(', ')
                ];
            })
        ];
        $filename = 'raport-spotkan.pdf';
        $view = 'reports.meetings';

        $pdf = PDF::loadView($view, $data);
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public static function generateVacationsReport(array $ids)
    {
        $records = Vacation::with(['user', 'notes'])->whereIn('id', $ids)->get();
        $data = [
            'title' => 'Raport Urlopów',
            'date' => Carbon::now()->format('d-m-Y'),
            'records' => $records->map(function ($record) {
                return [
                    'user' => $record->user->name,
                    'start_date' => Carbon::parse($record->start_at)->format('d-m-Y'),
                    'end_date' => Carbon::parse($record->end_at)->format('d-m-Y'),
                    'status' => $record->status,
                    'message' => $record->message
                ];
            })
        ];
        $filename = 'raport-urlopow.pdf';
        $view = 'reports.vacations';

        $pdf = PDF::loadView($view, $data);
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();    
        }, $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}

