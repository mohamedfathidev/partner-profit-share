<?php

namespace App\Repositories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Collection;

class PartnerReportRepository
{
    public function getPartnersTransactionsAndProfits($startDate, $endDate): Collection
    {
        return Partner::with(['transactions', 'profitShares'])
            ->whereHas('transactions', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            })
            ->orWhereHas('profitShares', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            })
            ->orWhere('active', 1)
            ->get();
    }

}
