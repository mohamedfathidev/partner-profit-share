<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'percentage', 'active'];


    public function profitShares(): MorphMany
    {
        return $this->morphMany(ProfitShare::class, 'profitable');
    }

}
