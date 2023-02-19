<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'summ',
        'employee',
        'agreement',
        'organisation'
    ];

    private function employee(): BelongsTo {
        $this->belongsTo(User::class);
    }

    public function agreement(): HasOne {
        $this->hasOne(Agreement::class);
    }
}
