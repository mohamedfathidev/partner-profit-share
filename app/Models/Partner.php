<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'initial_balance', 'address', 'phone', 'active'];

    // partner has many transactions
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function profitShares(): MorphMany
    {
        return $this->morphMany(ProfitShare::class, 'profitable');
    }

    // Accessor for calculating current balance without need to store it in DB or have current_balance column
    // note : to retrieve the sum of balance from accessor that work on a single partner use this => Partner::all()->sum('balance');
    public function getBalanceAttribute(): float
    {
        $deposits = $this->transactions()->where('type', 'deposite')->sum('amount');

        $withdrawals = $this->transactions()->where('type', 'withdrawal')->sum('amount');

        return $this->initial_balance + $deposits - $withdrawals;
    }
}
