<?php

namespace App\Models;

use App\Models\Type;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fee extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['quantity', 'expense_report_id', 'type_id'];

    public function expenseReport(): BelongsTo
    {
        return $this->belongsTo(ExpenseReport::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->quantity * ($this->type->amount / 100), 2, ',', ' ') . ' €';
    }

}
