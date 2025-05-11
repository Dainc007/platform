<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateReportRequest;
use App\Services\ReportService;
use Spatie\LaravelPdf\PdfBuilder;
use function Spatie\LaravelPdf\Support\pdf;

class GenerateReportController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws \Exception
     */
    public function __invoke(GenerateReportRequest $request): PdfBuilder
    {
         $type = $request->validated('type');
         $ids = $request->validated('ids');

        $data = match ($type) {
            'meetings' => ReportService::generateMeetingsReport($ids),
            'vacations' => ReportService::generateVacationsReport($ids),
            default => throw new \Exception('Invalid report type'),
        };

        return pdf()
            ->view($data['view'], $data)
            ->name($data['filename']);

    }
}
