<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['amount', 'type', 'partner_id', 'date', 'note'];

    // each transaction belongs to one partner 
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    protected $casts = [
        'date' => 'date',
    ];


}