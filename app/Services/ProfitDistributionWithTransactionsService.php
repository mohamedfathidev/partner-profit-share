<?php

namespace App\Services;

use App\Models\Manager;
use App\Models\Partner;
use Carbon\Carbon;

class ProfitDistributionWithTransactionsService
{
    public function calculateManagersProfit ($netProfit, $monthProfitId): float|int
    {
        $managers = Manager::where('active', 1)->get();

        $totalManagersProfit = 0;

        foreach ($managers as $manager) {
            $managerMoney = ($manager->percentage / 100) * $netProfit;
            $manager->profitShares()->create([
                "month_profit_id" => $monthProfitId,
                "profit_share" => $managerMoney,
                "date" => Carbon::now()->toDateString(),
            ]);

            $totalManagersProfit += $managerMoney;
        }

        return $netProfit - $totalManagersProfit;
    }



    public function calculatePartnersEligibleBalancesForCurrentMonth ($month, $year): array
    {
        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfDay();  // e.g. 1/3/2025
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay();

        $partners = Partner::where('active', 1)->get();

        $eligibleBalances = [];

        foreach ($partners as $partner) {

            // ❌ N+1 Problem
            // Instead make something like that
            /*
             * $partners = Partner::with(['transactions'])->where('active', 1)->get();

                $depositsBefore = $partner->transactions
                    ->filter(fn($t) => $t->type === 'deposite' && $t->date < $startOfMonth)
                    ->sum('amount');

            $partner->transactions->filter(function ($transaction) use ($startOfMonth) {
                return $transaction->type === 'deposite' && $transaction->date < $startOfMonth;
            })->sum('amount');

            */
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

    public function calculatePartnersProfit ($remainingMoney, $monthProfitId, $month, $year): void
    {
        $eligibleBalances = $this->calculatePartnersEligibleBalancesForCurrentMonth($month, $year);

        // calculate the total right balance using array_sum()
        $totalBalance = array_sum($eligibleBalances);


        foreach ($eligibleBalances as $partnerId => $profitableBalance) {
            $partnerMoney = ($profitableBalance / $totalBalance )  * $remainingMoney;
            Partner::find($partnerId)->profitShares()->create([
                "month_profit_id" => $monthProfitId,
                "profit_share" => $partnerMoney,
                "date" => Carbon::now()->toDateString(),
            ]);
        }
    }
}
