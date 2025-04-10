<?php

namespace App\Services;

use App\Models\MonthProfit;
use Carbon\Carbon;

class CheckMonthClosedService
{
    public function monthIsClosed(Carbon $date): bool
    {
        return MonthProfit::where('month', $date->month)
            ->where('year', $date->year)
            ->exists();
    }

}
