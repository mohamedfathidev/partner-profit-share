<?php

namespace App\Http\Controllers;



use App\Services\ReportService;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use PDF;
use Carbon\Carbon;
use App\Models\Partner;
use App\Models\PartnerHistory;
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

    public function showPartnerMonthlyForm(): View
    {
        $partners = Partner::select('id', 'name')->get();
        return view('reports.partner-monthly-report', compact('partners'));

    }

    public function generatePartnerMonthlyReport(Request $request, ReportService $reportService): void
    {
        $request->validate([
            "partner_id" => "required"
        ],[
            "partner_id.required" => "يجب إختيار شريك أولا"
        ]);

        $reportService->generatePartnerMonthlyReport($request->partner_id, $request->get('year'), $request->get('month'));
    }

    public function showPartnerAnnualForm(): View
    {
        $partners = Partner::select('id', 'name')->get();
        return view('reports.partner-annual-report', compact('partners'));

    }

    public function generatePartnerAnnualReport(Request $request, ReportService $reportService): void
    {
        $request->validate([
            "partner_id" => "required"
        ],[
            "partner_id.required" => "يجب إختيار شريك أولا"
        ]);

        $reportService->generatePartnerAnnualReport($request->partner_id, $request->get('from_date'), $request->get('to_date'));
    }


    public function showPartnersHistory(): View
    {

        $partnersHistory = PartnerHistory::all();
        return view('partners-history', compact('partnersHistory'));
    }

}