<?php

namespace App\Repositories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Collection;

class PartnerReportRepository
{
    public function getPartnersTransactionsAndProfits($startDate, $endDate): Collection
    {
        return Partner::with([
            'transactions' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            },
            'profitShares' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }
        ])
        ->orWhere('active', 1)
        ->get();
    }

    public function getPartnerTransactionsAndProfits($partnerId, $startDate, $endDate): Partner
    {
        return Partner::with([
            'transactions' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }, 
            'profitShares' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }
        ])
        ->where('id', $partnerId)
        ->first();
    }

}