<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'organisation',
        'preagreement',
        'employee',
        'start',
        'end',
        'payment'
    ];

    protected $casts = [
      'payment' => 'boolean'
    ];

    private function organisation(): BelongsTo {
        return $this->belongsTo(Organisation::class);
    }

    public function preagreement(): HasOne {
        return $this->hasOne(Preagreement::class);
    }

    private function employee(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    private function city(): BelongsToMany {
        return $this->belongsToMany(City::class);
    }
}
