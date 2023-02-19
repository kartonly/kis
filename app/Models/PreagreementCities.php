<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreagreementCities extends Model
{
    use HasFactory;

    protected $fillable = [
        'preagreementId',
        'cityId'
    ];

    public $timestamps = false;

    public function preagreement(): BelongsTo{
        return $this->belongsTo(Preagreement::class);
    }
    public function cities(): BelongsTo{
        return $this->belongsTo(City::class);
    }
}
