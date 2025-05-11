<?php

namespace App\Http\Controllers; 

use App\Http\Requests\GenerateReportRequest;
use Illuminate\Http\Request;
use App\Services\ReportService;

class GenerateReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GenerateReportRequest $request)
    {
        $type = $request->validated('type');
        $ids = $request->validated('ids');
        match ($type) {
            'meetings' => ReportService::generateMeetingsReport($ids),  
            'vacations' => ReportService::generateVacationsReport($ids),
            default => throw new \Exception('Invalid report type'),
        }; 
    
    }    
}
