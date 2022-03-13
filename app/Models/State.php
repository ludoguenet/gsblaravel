<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function expenseReports(): HasMany
    {
        return $this->hasMany(ExpenseReport::class);
    }
}
