<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Manager;
use App\Models\Partner;
use Illuminate\Support\Facades\DB;


class ProfitDistributionWithTransactionsService
{
    public function distributeMonthlyProfit(float $netProfit, int $monthProfitId, int $month, int $year): void
    {
        // make the distribution as one transaction (all or not)
        DB::transaction(function () use ($netProfit, $monthProfitId, $month, $year) {
            $remainingProfit = $this->distributeManagersProfit($netProfit, $monthProfitId);

            if ($remainingProfit > 0) {
                $this->distributePartnersProfit($remainingProfit, $monthProfitId, $month, $year);
            }
        });
    }

    public function distributeManagersProfit(float $netProfit, int $monthProfitId): float|int
    {
        $managers = Manager::where('active', 1)->get();

        $totalManagersProfit = 0;

        if ($managers->count() > 0) {  // علشان ميدخلش اللوب أصلا
            foreach ($managers as $manager) {
                $managerMoney = ($manager->percentage / 100) * $netProfit;
                $manager->profitShares()->create([
                    "month_profit_id" => $monthProfitId,
                    "profit_share" => $managerMoney,
                    "date" => Carbon::now()->toDateString(),
                ]);

                $totalManagersProfit += $managerMoney;
            }
        }

        return $netProfit - $totalManagersProfit;

    }


    public function distributePartnersProfit($remainingMoney, $monthProfitId, $month, $year): void
    {
        $eligibleBalances = $this->getPartnersEligibleBalances($month, $year);

        // calculate the total right balance using array_sum()
        $totalBalance = array_sum($eligibleBalances);


        foreach ($eligibleBalances as $partnerId => $profitableBalance) {
            $partnerMoney = ($profitableBalance / $totalBalance)  * $remainingMoney;
            Partner::find($partnerId)->profitShares()->create([
                "month_profit_id" => $monthProfitId,
                "profit_share" => $partnerMoney,
                "date" => Carbon::now()->toDateString(),
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
