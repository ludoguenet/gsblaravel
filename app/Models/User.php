<?php

namespace App\Models;

use App\Models\ExpenseReport;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;
    protected $guarded = [];

    public function expenseReports(): HasMany
    {
        return $this->hasMany(ExpenseReport::class);
    }

    public function fees()
    {
        return $this->hasManyThrough(Fee::class, ExpenseReport::class);
    }
}
