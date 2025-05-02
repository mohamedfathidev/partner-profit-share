<?php

namespace App\Services;

use App\Repositories\PartnerReportRepository;
use Carbon\Carbon;

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
        $startOfMonth = Carbon::createFromDate($year ?? now()->year, $month ?? now()->month , '1')->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year ?? now()->year, $month ?? now()->month, '1')->endOfMonth()->endOfDay();

        // Partners
        $partners = $this->partnerReportRepo->getPartnersTransactionsAndProfits($startOfMonth, $endOfMonth);

        // Calculate totals
        $totalArray = $this->calculateTotals($partners);

        $data = [];
        $data['partners'] = $partners;
        $data['totalArray'] = $totalArray;
        $data['startOfMonth'] = $startOfMonth;

        // Generate pdf
        $this->pdfService->generatePdf('pdf.general-monthly-report', $data);
    }

    public function generateGeneralAnnualReport($fromDate, $toDate): void
    {
        $fromDate = Carbon::parse($fromDate);
        $toDate = Carbon::parse($toDate);

        $partners = $this->partnerReportRepo->getPartnersTransactionsAndProfits($fromDate, $toDate);
        // Calculate totals
        $totalArray = $this->calculateTotals($partners);

        $data = [];
        $data['partners'] = $partners;
        $data['totalArray'] = $totalArray;
        $data['fromDate'] = $fromDate;
        $data['toDate'] = $toDate;

        $this->pdfService->generatePdf('pdf.general-annual-report', $data);
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

}
