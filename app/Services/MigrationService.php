<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Partner;
use App\Models\PartnerHistory;
use App\Models\ProfitShare;
use App\Models\Transaction;

class MigrationService
{

    public function migrateAndUpdate()
    {
        $roundStartDate = Carbon::createFromDate(now()->subYear()->year, (int)setting("endRound"), 1)->startOfDay(); // 1-9-2024
        $roundEndDate = Carbon::createFromDate(now()->year, (int)setting("endRound"), 1)->subDay()->endOfDay(); // 31-8-2025

        $totalDeposits = Transaction::where('type', 'withdrawal')->whereBetween('date', [$roundStartDate, $roundEndDate])->sum('amount');
        $totalWithdrawals = Transaction::where('type', 'deposite')->whereBetween('date', [$roundStartDate, $roundEndDate])->sum('amount');

        // profitShare for 
        // Before migrations just select the active paratners 

        // notes : the start and end of the round 1-9-2024 to 31-8-2025

        // ممكن نخلي اللى حالتهم أكتيف يتغير البلانس بتاعهم و ممكن نخلي اللى مش أكتيف نفس بلانس

        if (PartnerHistory::where('year', now()->year)->exists())
        {
            return false;

        }


        $partners = Partner::with('profitShares')->get();
        foreach($partners as $partner)
        {
            $profitShareRound = $partner->profitShares->whereBetween('date', [$roundStartDate, $roundEndDate])->sum('profit_share');

            PartnerHistory::create([
                "year" => now()->year,
                "date" => now()->toDateString(),
                "initial_yearly_balance" => $partner->initial_balance,
                "total_deposits" => $totalDeposits,
                "total_withdrawals" => $totalWithdrawals,
                "balance_after" => $profitShareRound,
                "partner_id" => $partner->id,
            ]);

            // update inital_balance for partner
            $partner->update([
                "initial_balance" => $profitShareRound
            ]);

        }

        // Update the note column to nofity that it is the month of migration
        $startOfMonth = $roundEndDate->copy()->startOfMonth();
        $endOfMonth = $roundEndDate->copy()->endOfMonth();
        ProfitShare::whereBetween('date', [$startOfMonth, $endOfMonth])->update(['note' => 'تم الترحيل و بداية سنة مالية جديدة']);

        return true;
    }

}