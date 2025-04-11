<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class ReportController extends Controller
{
    public function showGeneralMonthlyReport(Request $request): View
    {
        $startOfMonth = Carbon::createFromDate($request->get('year'), $request->get('month'), '1')->startOfMonth();
        $endOfMonth = Carbon::createFromDate($request->get('year'), $request->get('month'), '1')->endOfMonth()->endOfDay();

        $partners = Partner::with(['transactions', 'profitShares'])
            ->whereHas('transactions', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
            })
            ->whereHas('profitShares', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
            })
            ->orWhere('active', 1)
            ->get();

        // Statics
        $totalBalance = $partners->sum('balance');

        // Total withdrawals (sum of all withdrawals across all partners)
        $totalWithdrawals = $partners->sum(function ($partner) {
            return $partner->transactions->where('type', 'withdrawal')->sum('amount');
        });

        // Total deposits (sum of all deposits across all partners)
        $totalDeposits = $partners->sum(function ($partner) {
            return $partner->transactions->where('type', 'deposite')->sum('amount');
        });

        // Total transactions count (sum of all transactions)
        $totalTransactions = $partners->sum(function ($partner) {
            return $partner->transactions->count();
        });

        $totalProfitShares = $partners->sum(function ($partner) {
            return $partner->profitShares->sum('profit_share');
        });

        return view('reports.month-report', compact('partners', 'totalBalance', 'totalWithdrawals', 'totalDeposits', 'totalTransactions', 'totalProfitShares'));
    }

    public function showGeneralAnnualReport(): View
    {
        return view('reports.annual-report');
    }

    public function generateGeneralMonthlyReport(Request $request): View
    {

    }

    /**
     * @throws MpdfException
     */
    /**
     * @throws MpdfException
     */
    public function generateMonthlyPdf(Request $request)
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

        // Initialize mPDF with RTL support
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans', // Supports Arabic
            'direction' => 'rtl', // Right-to-left for Arabic
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
            'tempDir' => storage_path('temp')
        ]);

        // Render the view with data
        $html = view('reports.month-report', compact(
            'partners',
            'totalBalance',
            'totalWithdrawals',
            'totalDeposits',
            'totalTransactions',
            'totalProfitShares',
            'startOfMonth',
            'endOfMonth'    
        ))->render();

        // Write HTML to PDF
        $mpdf->WriteHTML($html);

        // Output the PDF
        return $mpdf->Output('monthly_report.pdf', 'I');
    }

    public function generatePDF()
    {
        // تهيئة mPDF مع دعم اللغة العربية
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'tajawal', // استخدمنا خط Tajawal للعربية
            'orientation' => 'P',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
            'tempDir' => storage_path('temp')
        ]);

        // إضافة CSS إضافي
//        $stylesheet = file_get_contents(public_path('css/pdf-styles.css'));
//        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

        // جلب محتوى صفحة Blade مع البيانات
        $html = view('pdf', [
            'partners' => [
                ['name' => 'أحمد محمد', 'share' => '40%', 'sales' => 'SAR 25,000.00', 'profit' => 'SAR 10,000.00', 'amount' => 'SAR 4,000.00'],
                ['name' => 'خالد عبدالله', 'share' => '35%', 'sales' => 'SAR 25,000.00', 'profit' => 'SAR 10,000.00', 'amount' => 'SAR 3,500.00'],
                ['name' => 'سارة علي', 'share' => '25%', 'sales' => 'SAR 25,000.00', 'profit' => 'SAR 10,000.00', 'amount' => 'SAR 2,500.00'],
            ],
            'total_sales' => 'SAR 25,000.00',
            'total_expenses' => 'SAR 15,000.00',
            'net_profit' => 'SAR 10,000.00',
            'total_partners_profit' => 'SAR 10,000.00'
        ])->render();

        // كتابة HTML في ملف PDF
        $mpdf->WriteHTML($html);

        // تحميل الملف PDF للمستخدم
        return $mpdf->Output('تقرير_أرباح_الشركاء.pdf', 'D');
    }


    public function generateAnnualReport()
    {

    }
}
