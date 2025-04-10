<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthProfit extends Model
{
    protected $fillable = ['total_profit', 'unused_goods', 'month', 'year', 'distribution_profit'];


}
