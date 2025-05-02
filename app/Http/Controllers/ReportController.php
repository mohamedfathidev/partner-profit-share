<?php

namespace App\Http\Controllers;



use App\Services\ReportService;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use PDF;
use Carbon\Carbon;
use App\Models\Partner;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showGeneralMonthlyForm(): View
    {
        return view('reports.general-monthly-report');
    }

    public function generateGeneralMonthlyReport(Request $request, ReportService $reportService): void
    {
        $reportService->generateGeneralMonthlyReport($request->get('year'), $request->get('month'));
    }

    public function showGeneralAnnualForm(): View
    {
        return view('reports.general-annual-report');
    }


    public function generateGeneralAnnualReport(Request $request, ReportService $reportService): void
    {
        $reportService->generateGeneralAnnualReport($request->get('from_date'), $request->get('to_date'));
    }

}
