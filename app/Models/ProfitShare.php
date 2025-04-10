<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProfitShare extends Model
{
    protected $fillable = ['month_profit_id', 'profit_share', 'date'];
    public function profitable(): MorphTo
    {
        return $this->morphTo();
    }
}
