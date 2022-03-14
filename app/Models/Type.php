<?php

namespace App\Models;

use App\Models\Fee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function fees(): HasMany
    {
        return $this->hasMany(Fee::class);
    }
}
