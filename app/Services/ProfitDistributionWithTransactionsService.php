<?php

namespace App\Services;

use App\Exceptions\NoEligiblePartnersException;
use Carbon\Carbon;
use App\Models\Manager;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;


class ProfitDistributionWithTransactionsService
{
    public function distributeMonthlyProfit(float $netProfit, int $monthProfitId, int $month, int $year, $date): bool
    {
        DB::transaction(function () use ($netProfit, $monthProfitId, $month, $year, $date) {
            $remainingProfit = $this->distributeManagersProfit($netProfit, $monthProfitId, $date);

            if ($remainingProfit > 0) {
                $this->distributePartnersProfit($remainingProfit, $monthProfitId, $month, $year, $date);
            }
        });
        return true;
    }

    public function distributeManagersProfit(float $netProfit, int $monthProfitId, $date): float|int
    {
        $managers = Manager::where('active', 1)->get();

        $totalManagersProfit = 0;

        if ($managers->count() > 0) {  // علشان ميدخلش اللوب أصلا
            foreach ($managers as $manager) {
                $managerMoney = ($manager->percentage / 100) * $netProfit;
                $manager->profitShares()->create([
                    "month_profit_id" => $monthProfitId,
                    "profit_share" => $managerMoney,
                    "date" => $date,
                ]);

                $totalManagersProfit += $managerMoney;
            }
        }

        return $netProfit - $totalManagersProfit;
    }


    public function distributePartnersProfit(float $remainingMoney, int $monthProfitId, int $month, int $year, $date): void
    {

            $eligibleBalances = $this->getPartnersEligibleBalances($month, $year);

            // calculate the total right balance using array_sum()
            $totalBalance = array_sum($eligibleBalances);

            if ($totalBalance <= 0) {
                throw new NoEligiblePartnersException("لا يوجد رصيد للشركاء لتوزيعه");
            }
                foreach ($eligibleBalances as $partnerId => $profitableBalance) {
                    $partnerMoney = ($profitableBalance / $totalBalance)  * $remainingMoney;
                    $zakat = $partnerMoney * 0.002;
                    $partnerMoneyAfterZakat = $partnerMoney - $zakat;
                    Partner::find($partnerId)->profitShares()->create([
                        "month_profit_id" => $monthProfitId,
                        "profit_share" => $partnerMoneyAfterZakat,
                        "date" => $date,
                    ]);
                }
                    
    }

    public function getPartnersEligibleBalances($month, $year): array
    {
        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfDay();  // e.g. 1/3/2025
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay();

        $partners = Partner::where('active', 1)->get();

        $eligibleBalances = [];

        foreach ($partners as $partner) {

            $deposits = $partner->transactions()
                ->where('type', 'deposite')
                ->where('date', '<', $startOfMonth)
                ->sum('amount');

            // ❌ N+1 Problem
            $withdrawals = $partner->transactions()
                ->where('type', 'withdrawal')
                ->where('date', '<', $startOfMonth)
                ->sum('amount');

            // ❌ N+1 Problem
            $withdrawalInCurrentMonth = $partner->transactions()
                ->where('type', 'withdrawal')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $currentBalanceBeforeMonth = $partner->initial_balance + $deposits - $withdrawals;

            $eligibleBalance = max(0, $currentBalanceBeforeMonth - $withdrawalInCurrentMonth);  // Edit to make a dynamic balance

            $eligibleBalances[$partner->id] = $eligibleBalance;
        }

        return $eligibleBalances;
    }
}
