<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Preagreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisationId',
        'clientId',
        'TouristsCount',
        'employee',
        'start',
        'end',
        'agreement'
    ];

    public function organisation(): BelongsTo {
        return $this->belongsTo(Organisation::class);
    }

    public function client(): BelongsTo {
        return $this->belongsTo(Clients::class);
    }

    public function employee(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function cities(): HasMany {
        return $this->hasMany(PreagreementCities::class);
    }
}
