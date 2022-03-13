<?php

namespace App\Models;

use App\Models\Type;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fee extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['amount', 'expense_report_id', 'type_id'];

    public function expenseReport(): BelongsTo
    {
        return $this->belongsTo(ExpenseReport::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value / 100, 2, ',', ' '),
            set: fn ($value) => str_replace(',', '.', $value) * 100
        );
    }
}
