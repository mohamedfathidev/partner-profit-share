<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerHistory extends Model
{
    protected $fillable = [
        'partner_id',
        'year',
        'date',
        'initial_yearly_balance',
        'total_deposits',
        'total_withdrawals',
        'balance_after',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
