<?php

namespace App\Models;

use App\Models\User;
use App\Models\State;
use App\Models\ExtraFee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseReport extends Model
{
    use HasFactory;

    protected $appends = ['totalOfTotals'];
    protected $fillable = ['user_id', 'state_id'];

    public function fees(): HasMany
    {
        return $this->hasMany(Fee::class);
    }

    public function extraFees(): HasMany
    {
        return $this->hasMany(ExtraFee::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Custom Attributes
     */
    public function getFeesTotalAttribute(): float|int
    {
        return $this->fees->sum(function (Fee $fee) {
            return $fee->quantity * $fee->type->amount;
        });
    }
}
