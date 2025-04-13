<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MonthProfit extends Model
{
    protected $fillable = ['total_profit', 'unused_goods', 'month', 'year', 'distribution_profit'];

    public function profitShares(): HasMany
    {
        return $this->hasMany(ProfitShare::class, 'month_profit_id');
    }

}
