<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proof extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['filename', 'extra_fee_id'];

    public function extraFee(): BelongsTo
    {
        return $this->belongsTo(ExtraFee::class);
    }
}
