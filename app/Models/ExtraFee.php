<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExtraFee extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['label', 'amount'];

    public function expenseReport(): BelongsTo
    {
        return $this->belongsTo(ExpenseReport::class);
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value / 100, 2, ',', ' '),
            set: fn ($value) => str_replace(',', '.', $value) * 100
        );
    }
}
