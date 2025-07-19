<?php

namespace App\Services;

use App\Repositories\PartnerReportRepository;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;


class ReportService
{
    private PartnerReportRepository $partnerReportRepo;
    private PdfService $pdfService;

    public function __construct (PartnerReportRepository $partnerReportRepo, PdfService $pdfService)
    {
        $this->partnerReportRepo = $partnerReportRepo;
        $this->pdfService = $pdfService;
    }

    public function generateGeneralMonthlyReport($year, $month): void
    {
        try {
            $startOfMonth = Carbon::createFromDate($year ?? now()->year, $month ?? now()->month , '1')->startOfMonth();
            $endOfMonth = Carbon::createFromDate($year ?? now()->year, $month ?? now()->month, '1')->endOfMonth()->endOfDay();

            $partners = $this->partnerReportRepo->getPartnersTransactionsAndProfits($startOfMonth, $endOfMonth);
            $totalArray = $this->calculateTotals($partners);

            $data = [];
            $data['partners'] = $partners;
            $data['totalArray'] = $totalArray;
            $data['startOfMonth'] = $startOfMonth;

            $this->pdfService->generatePdf('pdf.general-monthly-report', $data);
        } catch (\Exception $e) {
            \Log::error('Failed to generate monthly report: ' . $e->getMessage());
            throw new \Exception('فشل إنشاء التقرير. يرجى المحاولة لاحقًا.');
        }

    }

    public function generateGeneralAnnualReport($fromDate, $toDate): void
    {
        try {
            $fromDate = Carbon::parse($fromDate);
            $toDate = Carbon::parse($toDate);

            $partners = $this->partnerReportRepo->getPartnersTransactionsAndProfits($fromDate, $toDate);
            $totalArray = $this->calculateTotals($partners);

            $data = [];
            $data['partners'] = $partners;
            $data['totalArray'] = $totalArray;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;

            $this->pdfService->generatePdf('pdf.general-annual-report', $data);
        } catch (\Exception $e) {
            \Log::error('Failed to generate annual report: ' . $e->getMessage());
            throw new \Exception('فشل إنشاء التقرير. يرجى المحاولة لاحقًا.');
        }

    }

    public function calculateTotals($partners): array
    {

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

        return [
            "totalBalance" => $totalBalance,
            "totalWithdrawals" => $totalWithdrawals,
            "totalDeposits" => $totalDeposits,
            "totalTransactions" => $totalTransactions,
            "totalProfitShares" => $totalProfitShares
        ];
    }

    public function generatePartnerMonthlyReport($partnerId, $year, $month)
    {
        try {
            $startOfMonth = Carbon::createFromDate($year, $month, '1')->startOfMonth();
            $endOfMonth = Carbon::createFromDate($year, $month, '1')->endOfDay()->endOfMonth();

            $partner = $this->partnerReportRepo->getPartnerTransactionsAndProfits($partnerId, $startOfMonth, $endOfMonth);

            $data = [];

            $data['partner'] = $partner;
            $data['startOfMonth'] = $startOfMonth;
            $data['endOfMonth'] = $endOfMonth;

            $this->pdfService->generatePartnerPdf('pdf.partner-monthly-report', $data);

        } catch(\Exception $e) {
            \Log::error('Failed to generate partner monthly report'.$e->getMessage());
            throw new \Exception('فشل إنشاء التقرير. يرجى المحاولة لاحقًا.'. $e->getMessage());
        }
        
    }

    public function generatePartnerAnnualReport($partnerId, $fromDate, $toDate) 
    {
        try {
            $fromDate = Carbon::parse($fromDate);
            $toDate = Carbon::parse($toDate);


            $partner = $this->partnerReportRepo->getPartnerTransactionsAndProfits($partnerId, $fromDate, $toDate);

            $data = [];

            $data['partner'] = $partner;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;

            $this->pdfService->generatePartnerPdf('pdf.partner-annual-report', $data);

        } catch(\Exception $e) {
            \Log::error('Failed to generate partner monthly report'.$e->getMessage());
            throw new \Exception('فشل إنشاء التقرير. يرجى المحاولة لاحقًا.'. $e->getMessage());
        }
    }

}

