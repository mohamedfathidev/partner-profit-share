<?php

namespace App\Http\Controllers;


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

    public function generateGeneralMonthlyReport(Request $request)
    { 
        // Get the same data as in showGeneralMonthlyReport
        $startOfMonth = Carbon::createFromDate($request->get('year') ?? now()->year, $request->get('month') ?? now()->month , '1')->startOfMonth();
        $endOfMonth = Carbon::createFromDate($request->get('year') ?? now()->year, $request->get('month') ?? now()->month, '1')->endOfMonth()->endOfDay();

        $partners = Partner::with(['transactions', 'profitShares'])
            ->whereHas('transactions', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
            })
            ->orWhereHas('profitShares', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
            })
            ->orWhere('active', 1)
            ->get();
 
        // Calculate totals
        $totalBalance = $partners->sum('balance');
        $totalWithdrawals = $partners->sum(function ($partner) {
            return $partner->transactions->where('type', 'withdrawal')->sum('amount');
        });
        $totalDeposits = $partners->sum(function ($partner) {
            return $partner->transactions->where('type', 'deposite')->sum('amount');
        });
        $totalTransactions = $partners->sum(function ($partner) {
            return $partner->transactions->count();
        });
        $totalProfitShares = $partners->sum(function ($partner) {
            return $partner->profitShares->sum('profit_share');
        });


        $pdf = PDF::loadView('pdf.general-monthly-report', compact(
            'partners',
            'totalBalance',
            'totalWithdrawals',
            'totalDeposits',
            'totalTransactions',
            'totalProfitShares',
            'startOfMonth'
        ));

        // إضافة Watermark
        $pdf->getMpdf()->SetWatermarkText('AL-MANSOUR');
        $pdf->getMpdf()->showWatermarkText = true;
        $pdf->getMpdf()->watermarkTextAlpha = 0.1; // شفافية العلامة المائية

        $pdf->getMpdf()->SetHTMLHeader('
            <div style="text-align: center; font-family: Cairo; font-size: 12px; color: #666;">
                تقرير توزيع الأرباح الشهري - AL-MANSOUR
            </div>
        ');

        // إضافة الفوتر مع رقم الصفحة
        $pdf->getMpdf()->SetHTMLFooter('
            <div style="text-align: center; font-family: Cairo; font-size: 10px; color: #666;">
                صفحة  {PAGENO} 
            </div>
        ');

        return $pdf->stream('doc.pdf');

    }
}
